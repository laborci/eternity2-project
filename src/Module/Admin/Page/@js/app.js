import Brick from "zengular-brick";
import AppEventManager from "zengular-brick/src/app-event";
import CodexLayoutBrick from "./src/codex-frame/layout/brick";
import "./src/codex-admin/loader";

import menu from "./src/menu";
import CodexFormFrame from "./src/codex-admin/frame/brick";

import "./src/plugin-loader";

new (class {

	constructor() {
		this.appEventManager = new AppEventManager(document.body);
		Brick.registry.initialize();
		this.layout = document.querySelector(CodexLayoutBrick.selector).controller;
		this.layout.menu.addMenu(menu);
		this.appEventManager.listen('SHOW-FORM', (event) => this.menuEventHandler(event));


	}

	addMenus(menu) {
		for (let option in menu) {
			let menuItem = menu[option];
			menuItem.option = option;
			this.layout.menu.addMenuItem(menuItem.label, option, menuItem.icon);
		}
	}

	menuEventHandler(event) {
//		console.log(event)
		this.layout.content.show(CodexFormFrame, event.data);
	}

})();