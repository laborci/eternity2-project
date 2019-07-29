import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Input from "../input";

@Brick.register('codex-input-string', twig)
@Brick.useAppEventManager()
@Brick.registerSubBricksOnRender()

export default class InputString extends Input {

	getValue() { return this.$$('input-element').node.value;}
	setValue(value) { this.$$("input-element").node.value = value;}

}