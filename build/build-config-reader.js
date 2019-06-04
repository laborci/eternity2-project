let glob = require("glob");
let path = require("path");

module.exports = class BuildConfigReader{

	constructor(config){this.config = config;}

	get googlefonts(){return this.config.googlefonts; }

	get buildVersion(){return this.config.buildVersion; }

	get copy(){return this.config.copy; }

	get css(){return this.config.css; }

	get js(){return this.config.js; }

	get cssEntries(){ return this.constructor.getEntries(this.css, '*.less'); }

	get jsEntries(){
		return this.constructor.getEntries(this.js, '*.js', (entry) => {
			return {
				key  : entry.dest + entry.base,
				value: entry.src + entry.file
			};
		});
	}

	static getEntries(paths, pattern, converter = null){
		let entries = [];
		paths.forEach(pathEntry => {
			glob.sync(pattern, {cwd: pathEntry.src}).forEach(file => entries.push({
				src : pathEntry.src,
				dest: pathEntry.dest,
				file: file,
				ext : path.extname(file),
				base: file.slice(0, -path.extname(file).length)
			}));
		});
		if(converter !== null){
			let convertedEntries = {};
			entries.forEach(entry => {
				entry = converter(entry);
				convertedEntries[entry.key] = entry.value;
			});
			entries = convertedEntries;
		}
		return entries;
	}
};