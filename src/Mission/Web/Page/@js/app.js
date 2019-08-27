//import Brick            from "zengular-brick";
//import AppEventManager  from "zengular-brick/src/app-event";
//import CodexLayoutBrick from "./src/codex/layout/brick";
//import "./src/codex/loader";
//import "./src/eternity/loader";
//import menu             from "./src/menu";
//
//new (class{
//
//	constructor(){
//		this.appEventManager = new AppEventManager(document.body);
//		Brick.registry.initialize();
//		this.layout = document.querySelector(CodexLayoutBrick.selector).controller;
//		this.layout.menu.addMenu(menu);
//		this.appEventManager.listen('codex-menu-click', (event) => this.menuEventHandler(event));
//	}
//
//	addMenus(menu){
//		for(let option in menu){
//			let menuItem = menu[option];
//			menuItem.option = option;
//			this.layout.menu.addMenuItem(menuItem.label, option, menuItem.icon);
//		}
//	}
//
//	menuEventHandler(event){
//		this.layout.content.show(event.data.action.content, event.data.action);
//	}
//
//})();