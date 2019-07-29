import Brick       from "zengular-brick";
import twig        from "./template.twig";
import "./style.less";
import Input from "../input";

@Brick.register('codex-input-checkbox', twig)
@Brick.useAppEventManager()
@Brick.registerSubBricksOnRender()

export default class InputCheckbox extends Input{

    getValue(){
        return this.$$('input-element').node.checked;
    }


    setValue(value){
        this.$$('input-element').node.checked = value;
    }
}