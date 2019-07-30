import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Input from "../input";
import dateToDateTimeLocal from "phlex-datetime-local";

@Brick.register('codex-input-datetime', twig)
@Brick.useAppEventManager()
@Brick.registerSubBricksOnRender()

export default class InputDatetime extends Input {

	getValue() {
		let value = this.$$('input-element').node.value;
		return dateToDateTimeLocal(value,true, true);

	}
	setValue(value) {
		value =  dateToDateTimeLocal(value,true);
		this.$$("input-element").node.value = value;
	}

}
