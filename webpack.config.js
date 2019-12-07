const zBuild = new (require('zengular-build'))();
const packagejson = require('./package');
const CopyPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, options) => {

	let dev = options.mode === 'development';
	let prod = options.mode === 'production';

	return {
		name: 'Transpiler',
		entry: zBuild.entries,
		output: {filename: '[name].js', path: __dirname},
		resolve: {
			modules: ['node_modules', '/'],
			alias: packagejson["z-build"]["resolve-alias"]
		},
		plugins: [
			zBuild.verbump,
			new CopyPlugin(zBuild.copy),
			new MiniCssExtractPlugin({filename: '[name].css'}),
		],
		devtool: dev ? zBuild.devtool : false,
		module: {
			rules: [
				{
					test: /\.js$/,
					use: {
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env'],
							plugins: [
								["@babel/plugin-proposal-decorators", {"legacy": true}],
								"@babel/plugin-proposal-class-properties",
								"@babel/plugin-proposal-object-rest-spread",
								"@babel/plugin-proposal-optional-chaining"
							]
						}
					}
				},
				{
					test: /\.(html)$/,
					use: "html-loader"
				},
				{
					test: /\.twig$/,
					use: "twig-loader"
				},
				{
					test: /\.less$/,
					use: [
						{loader: MiniCssExtractPlugin.loader, options: {}},
						{loader: "css-loader", options: {url: false, minimize: true}},
						{loader: "postcss-loader"},
						{loader: "less-loader", options: {relativeUrls: false}}
					]
				},
				{
					test: /\.scss/,
					use: [
						{loader: MiniCssExtractPlugin.loader, options: {}},
						{loader: "css-loader", options: {url: false, minimize: true}},
						{loader: "postcss-loader"},
						{loader: "sass-loader", options: {}}
					]
				},
				{
					test: /\.css$/,
					use: [
						{loader: MiniCssExtractPlugin.loader, options: {}},
						{loader: "css-loader", options: {url: false, minimize: true}}
					]
				}
			]
		}
	}
};
