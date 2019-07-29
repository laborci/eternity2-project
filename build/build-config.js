module.exports = new (require("./build-config-reader"))({
	buildVersionFile: "./build-version",
	googlefonts: {
		fontlist: "google-fonts",
		path    : "../public/fonts/",
		css     : "google-fonts.css",
		srcify:{
			fontsurl: '/fonts/',
			srcpath: 'src/google-fonts.less'
		}
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


class ZengularBuilder{



}