import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";
import CodexAdminList from "../list/brick";


@Brick.register('codex-admin-frame', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminFrame extends Brick {


	onInitialize() {
	}

	route(data) {
		if (this.name !== data.name) {
			this.name = data.name;
			Ajax.request('/' + this.name + '/codexinfo').get().promise()
				.then(result => {
					this.codexinfo = result.json;
					this.setHeader();
					this.loadList();
				})
		}
	}

	onRender() {
		this.list = this.find(CodexAdminList.selector).controller;
		this.list.bindPagingDisplay({current: this.find("[data-for=current]"), count: this.find("[data-for=count]")});
	}

	loadList() { this.list.setup(this.codexinfo.list);}

	setHeader(header) {
		let icon = this.codexinfo.header.icon;
		let title = this.codexinfo.header.title;
		this.find('[data-placeholder=icon]').classList.add(...icon.split(' '));
		this.find('[data-placeholder=title]').innerHTML = title;
	}
}

