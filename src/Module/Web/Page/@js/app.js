import Brick            from "zengular-brick";
import AppEventManager  from "zengular-brick/src/app-event";
import CodexLayoutBrick from "./src/codex/layout/brick";
import "./src/codex/loader";
import "./src/eternity/loader";
import menu             from "./src/menu";

new (class{

	constructor(){
		this.appEventManager = new AppEventManager(document.body);
		Brick.registry.initialize();
		this.layout = document.querySelector(CodexLayoutBrick.selector).controller;
		this.addMenus(menu);
	}

	addMenus(menu){
		for(let option in menu){
			let menuItem = menu[option];
			menuItem.option = option;
			this.layout.menu.addMenuItem(menuItem.label, option, menuItem.icon);
		}
		this.appEventManager.listen('menu-click', (event) => this.menuEventHandler(menu[event.data.option]));
	}

	menuEventHandler(menuItem){
		this.layout.content.show(menuItem.content, menuItem.data);
	}

})();