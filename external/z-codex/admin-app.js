import Application      from "zengular/core/application";
import CodexLayoutBrick from "./frame/layout/brick";
import CodexFormFrame   from "./admin/frame/brick";

import "./admin/loader";
import "./plugins/loader";


export default class  AdminApplication extends Application{

	constructor(){
		super(false, true);
	}

	initialize(){
		this.listen('layout-rendered', (event)=>{
			console.log(event);
			this.layout = event.data.layout;
			this.run();
		});
	}

	run(){
		this.layout.menu.addMenu(this.menu);
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
