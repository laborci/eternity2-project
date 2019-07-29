import Brick       from "zengular-brick";
import twig        from "./template.twig";
import "./style.less";
import Input from "../input";

@Brick.register('codex-input-text', twig)
@Brick.useAppEventManager()
@Brick.registerSubBricksOnRender()

export default class InputText extends Input{

    getDefaultOptions(){
        return {
            rows: 5
        }
    }

    getValue(){
        return this.$$("input-element").node.value;
    }

    setValue(value){
        this.$$("input-element").node.value = value;
    }
}