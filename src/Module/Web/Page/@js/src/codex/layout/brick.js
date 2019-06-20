import Brick                   from "zengular-brick";
import twig                    from "./template.twig";
import "./style.less";
import CodexLayoutMenuBrick    from "../layout-menu/brick";
import CodexLayoutContentBrick from "../layout-content/brick";

@Brick.register('codex-layout', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexLayoutBrick extends Brick{

	onInitialize(){
		this.menuHeader = this.root.innerHTML;
	}

	onRender(){
		this.appEventManager.fire('rendered');
		this.menu = this.$(CodexLayoutMenuBrick.selector).get().controller;
		this.content = this.$(CodexLayoutContentBrick.selector).get().controller;
		this.menu.setHeader(this.menuHeader);
	}
}