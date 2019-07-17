import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";
import CodexAdminList from "../list/brick";
import "../tab-manager/brick";
import CodexAdminTabManager from "../tab-manager/brick";

@Brick.register('codex-admin-frame', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminFrame extends Brick {


	onInitialize() {
		this.appEventManager.listen('ITEM-SELECTED', event => {
			this.tabManager.open(this.codexinfo.urlBase, event.data.id);
		});
		this.appEventManager.listen('PAGING-CHANGED', event => {
			let page = event.data.page;
			let pageSize = event.data.pageSize;
			let count = event.data.count;

			let from = (page-1)*pageSize + 1;
			let to =  Math.min(page * pageSize, count);

			this.$$("page-current").get().innerHTML = `${from} - ${to}`;
			this.$$("page-count").get().innerHTML = count;
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
		this.$$('header-icon', e => e.classList.add(...this.codexinfo.header.icon.split(' ')));
		this.$$('header-title', e => e.innerHTML = this.codexinfo.header.title);
	}
}

