import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Input from "../input";
import dateToDateTimeLocal from "phlex-datetime-local";

@Brick.register('codex-input-date', twig)
@Brick.useAppEventManager()
@Brick.registerSubBricksOnRender()

export default class InputDate extends Input {

	getValue() {
		let value = this.$$('input-element').node.value;

	}
	setValue(value) {
		this.$$("input-element").node.value = value;
	}

}
