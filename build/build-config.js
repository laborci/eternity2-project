module.exports = new (require("./build-config-reader"))({
	buildVersionFile: "./build-version",
	googlefonts: {
		fontlist: "google-fonts",
		path    : "../public/fonts/",
		css     : "google-fonts.css"
	},
	copy       : [
		{src: "./node_modules/@fortawesome/fontawesome-pro/webfonts/", pattern: "*", dest: "../public/fonts/fontawesome/"},
		{src: "../assets/", pattern: "**", dest: "../public/", watch: true},
		{src: "../src/", pattern: "index.php", dest: "../public/", watch: true}
	],
	css        : [
		{src: "../src/Module/Web/Page/@css/", dest: "../public/web/css/"}
	],
	js         : [
		{src: "../src/Module/Web/Page/@js/", dest: "../public/web/js/"}
	]
});