import Brick                   from "zengular/core/brick";
import twig                    from "./template.twig";
import "./style.less";
import CodexLayoutMenuBrick    from "../menu/brick";
import CodexLayoutContentBrick from "../content/brick";

@Brick.register('codex-layout', twig)
@Brick.registerSubBricksOnRender()
export default class CodexLayoutBrick extends Brick{


	createViewModel() {
		return {
			title: this.dataset.title ? this.dataset.title : "Eternity Codex II",
			icon: this.dataset.icon ? this.dataset.icon : "fas fa-infinity",
			user: this.dataset.user,
			avatar: this.dataset.avatar
		}
	}

	onRender(){
		this.appEventManager.fire('rendered');
		this.menu = this.$(CodexLayoutMenuBrick.selector).get().controller;
		this.content = this.$(CodexLayoutContentBrick.selector).get().controller;
	}
}