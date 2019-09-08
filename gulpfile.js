let {series, parallel, watch, src, dest} = require('gulp');

let buildConfig = require('z-build').ConfigReader.load('./etc/z-build.json');
let VersionBump = require('z-build').VersionBump;

let prefixer = require('gulp-autoprefixer');
let less = require('gulp-less');
let uglifycss = require("gulp-uglifycss");
let GetGoogleFonts = require('get-google-fonts');

let fs = require('fs');
let path = require('path');
let crypto = require('crypto');

//--------------------------------------------------------------------------------------------

function startWatcher(cb) {
	buildConfig.css.forEach(entry => {
		watch(['**/*.less'], {cwd: entry.src}, compileLess);
		if(typeof buildConfig.googlefonts !== 'undefined')watch(buildConfig.googlefonts.src, getGoogleFonts);
	});

	buildConfig.copy.forEach(entry => {
		if (entry.watch) watch(entry.pattern, {cwd: entry.src}, copyWatched);
	});

	cb();
}


function getGoogleFonts(cb) {

	if(typeof buildConfig.googlefonts === 'undefined'){
		cb();
		return;
	}

	let dest = buildConfig.googlefonts.dest;
	let url = buildConfig.googlefonts.path;
	let promises = [];
	let outputs = [];

	buildConfig.googlefonts.src.forEach(src => {
		let source = JSON.parse(fs.readFileSync(src, {encoding: 'UTF-8'}));
		let hash = crypto.createHash('md5').update(src).digest('hex');

		outputs.push({
			src: dest + hash + '.css',
			dest: path.dirname(src) + '/' + source.css
		});

		let ggf = new GetGoogleFonts({
			userAgent: 'Mozilla/4.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
			overwriting: false,
			cssFile: hash + ".css",
			path: url,
			outputDir: dest,
			template: '{_family}-{weight}.{ext}'
		});
		promises.push(ggf.download([source.fonts, source.family]));
	});

	return Promise.all(promises).then(() => outputs.forEach(entry => fs.renameSync(entry.src, entry.dest)));
}

function compileLess(cb) {
	buildConfig.cssEntries.forEach(entry => {
		src(entry.src + entry.file)
			.pipe(less({paths: ['./node_modules']}))
			.pipe(uglifycss({"maxLineLen": 80, "uglyComments": true}))
			.pipe(prefixer('last 2 versions', 'ie 9'))
			.pipe(dest(entry.dest));
	});

	bumpVersion();
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
	bumpVersion();
	cb();
}

function bumpVersion() {
	(new VersionBump({file: path.resolve(__dirname, buildConfig.buildVersionFile)})).bump();
}

exports.default = series(copy, getGoogleFonts, compileLess, startWatcher);
exports.build = series(copy, getGoogleFonts, compileLess);
