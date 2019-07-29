let {series, parallel, watch, src, dest} = require('gulp');
let buildConfig = require('./build-config');
let prefixer = require('gulp-autoprefixer');
let less = require('gulp-less');
let uglifycss = require("gulp-uglifycss");
let googleWebFonts = require("gulp-google-webfonts");
let fs = require('fs');



function watcher(cb) {

	buildConfig.css.forEach(entry => {
		watch(['**/*.less'], {cwd: entry.src}, compileLess);
		watch([buildConfig.googlefonts.fontlist], {cwd: entry.src}, getGoogleFonts);
	});

	buildConfig.copy.forEach(entry => {
		if (entry.watch) watch(entry.pattern, {cwd: entry.src}, copyWatched);
	});

	cb();
}


function getGoogleFonts() {
	buildConfig.css.forEach(entry => {
		src(entry.src + buildConfig.googlefonts.fontlist)
			.pipe(googleWebFonts({
				fontsDir: buildConfig.googlefonts.path,
				cssDir: entry.dest,
				cssFilename: buildConfig.googlefonts.css,
				outBaseDir: '',
				relativePaths: true
			}))
			.pipe(dest())
		;
		//bumpVersion();

		if (typeof buildConfig.googlefonts.srcify !== 'undefined') {
			let src = entry.dest + buildConfig.googlefonts.css;
			let dest = entry.src + buildConfig.googlefonts.srcify.srcpath;
			fs.copyFileSync(src, dest);
			let str = fs.readFileSync(dest, {encoding: 'UTF-8'});
			const regex = /url\((.*)\//gm;
			let m;
			while ((m = regex.exec(str)) !== null) {
				if (m.index === regex.lastIndex) {regex.lastIndex++;}
				str = str.replace(m[1], '/fonts');
			}
			fs.writeFileSync(dest, str, {encoding: 'UTF-8'});
		}
	});
}

function compileLess(cb) {
	buildConfig.cssEntries.forEach(entry => {
		src(entry.src + entry.file)
			.pipe(less({paths: ['./node_modules']}))
			.pipe(uglifycss({"maxLineLen": 80, "uglyComments": true}))
			.pipe(prefixer('last 2 versions', 'ie 9'))
			.pipe(dest(entry.dest));
	});

	//bumpVersion();
	cb();
}

function copy(cb) {
	buildConfig.copy.forEach(entry => {src(entry.src + entry.pattern).pipe(dest(entry.dest)); });
	cb();
}

function copyWatched(cb) {

	buildConfig.copy.forEach(entry => {
		if (entry.watch) src(entry.src + entry.pattern).pipe(dest(entry.dest));
	});

	//	bumpVersion();
	cb();
}

function bumpVersion() {
	const path = require("path");
	const VB = require("./version-bump-plugin");
	(new VB({file: path.resolve(__dirname, buildConfig.buildVersionFile)})).bump();
}

exports.default = series(copy, compileLess, watcher);