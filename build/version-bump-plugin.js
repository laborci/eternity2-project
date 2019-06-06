class VersionBumpPlugin {
	constructor(options) { this.options = options; }

	bump(){
		let fs = require('fs');
		let version = 0;
		if (fs.existsSync(this.options.file)) version = fs.readFileSync(this.options.file);
		version ++;
		fs.writeFileSync(this.options.file, version);
	}

	apply(compiler) {
		compiler.hooks.done.tap('VersionBumpPlugin', stats => { this.bump(); });
	}
}

module.exports = VersionBumpPlugin;