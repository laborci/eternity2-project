import Brick    from "zengular/core/brick";
import twig     from "./template.twig";
import "./style.less";

@Brick.register('codex-layout-content', twig)
export default class CodexLayoutContentBrick extends Brick{

	onRender(){
		this.brick = null;
		this.content = null;
	}

	show(brick, data){
		if(this.brick !== brick){
			this.brick = brick;
			while(this.root.firstChild) this.root.removeChild(this.root.firstChild);
			this.content = brick.create('div', true).controller;
			this.root.appendChild(this.content.root);
		}
		this.content.route(data);
	}

}