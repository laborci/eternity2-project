import Brick from "zengular/core/brick";
import twig from "./template.twig";
import "./style.less";
import Input from "../input";

@Brick.register('codex-input-checkboxes', twig)
@Brick.registerSubBricksOnRender()
@Brick.renderOnConstruct(false)

export default class InputCheckboxes extends Input {

	getValue() {
		let checked = [];
		this.$$('input-element').nodes.forEach(input => this.checkInput(input, checked));
		return checked;
	}

	checkInput(input, array) {
		if (input.checked === true) {
			array.push(input.value);
		}
	}

	setValue(input) {
		this.$$("input-element").each(input => input.removeAttribute("checked"));
		this.$$('input-element').nodes.forEach(line => this.checkValue(input, line));
	}

	checkValue(input, line) {
		if (line.value === input) {
			line.checked = true;
		}
	}

	preprocessOptions(options){
		if(!(options.options instanceof Array)){
			let opts = [];
			for(let value in options.options)opts.push({value: value, label: options.options[value]});
			options.options = opts;
		}
		return options;
	}


}