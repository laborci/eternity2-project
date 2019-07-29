module.exports = new (require("./build-config-reader"))({
	buildVersionFile: "./build-version",
	googlefonts: {
		"src": [
			"../src/Module/Web/Page/@css/google-fonts.json",
			"../src/Module/Admin/Page/@css/google-fonts.json"
		],
		"dest": "../public/fonts/",
		"path": "/fonts/"
	},
	copy       : [
		{src: "./node_modules/@fortawesome/fontawesome-pro/webfonts/", pattern: "*", dest: "../public/fonts/fontawesome/"},
		{src: "../assets/", pattern: "**", dest: "../public/", watch: true},
		{src: "../src/", pattern: "index.php", dest: "../public/", watch: true}
	],
	css        : [
		{src: "../src/Module/Web/Page/@css/", dest: "../public/web/css/"},
		{src: "../src/Module/Admin/Page/@css/", dest: "../public/admin/css/"}
	],
	js         : [
		{src: "../src/Module/Web/Page/@js/", dest: "../public/web/js/"},
		{src: "../src/Module/Admin/Page/@js/", dest: "../public/admin/js/"}
	]
});


class ZengularBuilderConfig{

	constructor(){
		this.config = {};
	}

	set buildVersionFile(value){
		this.config.buildVersionFile = value;
	}




}