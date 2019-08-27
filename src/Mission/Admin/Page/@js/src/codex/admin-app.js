import Application from "zengular/core/application";
import CodexLayoutBrick from "./frame/layout/brick";
import menu from "./../menu";
import CodexFormFrame from "./admin/frame/brick";

import "./admin/loader";
import "./plugins/loader";

export default class  AdminApplication extends Application{

	run(){
		this.layout = document.querySelector(CodexLayoutBrick.selector).controller;
		this.layout.menu.addMenu(menu);
		this.listen('SHOW-FORM', (event) => this.menuEventHandler(event));
	}

	addMenus(menu) {
		for (let option in menu) {
			let menuItem = menu[option];
			menuItem.option = option;
			this.layout.menu.addMenuItem(menuItem.label, option, menuItem.icon);
		}
	}

	menuEventHandler(event) {
		this.layout.content.show(CodexFormFrame, event.data);
	}

};
