import Brick from "zengular/core/brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular/core/ajax";
import CodexAdminList from "../list/brick";
import "../tab-manager/brick";
import CodexAdminTabManager from "../tab-manager/brick";
import pluginManager from "../../plugin/plugin-manager";
import ListButtonPlugin from "../../plugin/types/ListButtonPlugin";

@Brick.register('codex-admin-frame', twig)
@Brick.registerSubBricksOnRender()
export default class CodexAdminFrame extends Brick {


	onInitialize() {
		this.appEventManager.listen('ITEM-SELECTED', event => {this.tabManager.open(this.codexinfo.urlBase, event.data.id);});
		this.appEventManager.listen('ADD-NEW-ITEM', event => {this.tabManager.open(this.codexinfo.urlBase, null);});
		this.appEventManager.listen('RELOAD-LIST', event => {this.list.reload(event.data.urlBase);})
		this.appEventManager.listen('PAGING-CHANGED', event => {
			let page = event.data.page;
			let pageSize = event.data.pageSize;
			let count = event.data.count;

			let from = (page - 1) * pageSize + 1;
			let to = Math.min(page * pageSize, count);

			this.$$("page-current").node.innerHTML = `${from} - ${to}`;
			this.$$("page-count").node.innerHTML = count;
		});
	}

	route(data) {
		if (this.name !== data.name) {
			this.name = data.name;
			Ajax.request('/' + this.name + '/codexinfo').get().promise()
				.then(result => {
					this.codexinfo = result.json;
					this.codexinfo.list.urlBase = this.codexinfo.urlBase;
					this.setHeader();
					this.loadList();
				})
		}
	}

	onRender() {
		this.list = this.find(CodexAdminList.selector).controller;
		this.tabManager = this.find(CodexAdminTabManager.selector).controller;
	}

	loadList() { this.list.setup(this.codexinfo.list);}

	setHeader() {
		this.$$('header-icon').each(e => e.classList.add(...this.codexinfo.header.icon.split(' ')));
		this.$$('header-title').each(e => e.innerHTML = this.codexinfo.header.title);
		this.$$('buttons').node.innerHTML = '';
		console.log(this.codexinfo)
		let plugins = pluginManager.get(this.codexinfo.list.plugins, ListButtonPlugin, this.list);
		plugins.forEach(plugin=>{
			let button = plugin.createButton();
			if (button) this.$$('buttons').node.appendChild(button);
		});
	}
}

