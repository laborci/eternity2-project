let buildConfig = require('z-build').ConfigReader.load('./z-build.json');
let VersionBump = require('z-build').VersionBump;

let path = require('path');

module.exports = [
	{
		name: 'Transpiler',
		entry: buildConfig.jsEntries,
		output: {filename: '[name].js', path: __dirname},
		resolve: {
			modules: ['node_modules']
		},
		plugins: [new VersionBump({file: path.resolve(__dirname, buildConfig.buildVersionFile)})],
		devtool: 'inline-source-map',
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
					test: /@\.less$/, // loads @*.less as a string
					use: ["html-loader", "less-loader"]
				},
				{
					test: /[^@]\.less$/,
					use: ["style-loader", "css-loader", "less-loader"]
				},
				{
					test: /\.css$/,
					use: ["style-loader", "css-loader"]
				}
			]
		}
	}
];
