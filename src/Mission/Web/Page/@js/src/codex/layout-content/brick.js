import Brick    from "zengular-brick";
import twig     from "./template.twig";
//import {router} from "zengular-router";
import "./style.less";

@Brick.register('codex-layout-content', twig)
export default class CodexLayoutContentBrick extends Brick{

	onRender(){
		this.tag = null;
		this.content = null;
	}

	show(tag, data){
		if(this.tag !== tag){
			this.tag = tag;
			while(this.root.firstChild) this.root.removeChild(this.root.firstChild);
			this.content = Brick.registry.getBrick(tag).create('div', true).controller;
			this.root.appendChild(this.content.root);
		}
		this.content.route(data);
	}

}