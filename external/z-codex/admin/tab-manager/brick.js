import Brick          from "zengular/core/brick";
import twig           from "./template.twig";
import "./style.less";
import "../tab/brick";
import CodexAdminTab  from "../tab/brick";
import CodexAdminForm from "../form/brick";


@Brick.register('codex-admin-tab-manager', twig)
@Brick.registerSubBricksOnRender()
export default class CodexAdminTabManager extends Brick {

	onInitialize() {
		this.listen('TAB-SELECTED', event => { this.selectTab(event.source);});
		this.listen('TAB-CLOSED', event => { this.removeTab(event.source);});
	}

	onRender() {}

	open(urlBase, id) {
		let tab = this.$(CodexAdminTab.selector + `[data-id="${id}"][data-type="${urlBase}"]`).node?.controller;
		console.log(tab)

		if (!tab) {
			CodexAdminTab.create()
			.then(newTab=> {
				tab = newTab;
				tab.root.dataset.id = id;
				tab.root.dataset.type = urlBase;
				tab.root.dataset.icon = 'fas fa-infinity';
				tab.root.dataset.label = '...';
				this.$$('tabs').node.appendChild(tab.root);
				return CodexAdminForm.create();
			})
			.then((form)=>{
				console.log(tab)
				console.log(form)
				tab.form = form;
				form.tab = tab;
				form.load(id, urlBase);
				this.$$('forms').node.appendChild(form.root);
				this.selectTab(tab);
			});
		}else this.selectTab(tab);
	}

	selectTab(tab) {
		this.$(CodexAdminTab.selector).filter('[data-selected=yes]', tab => tab.dataset.selected = 'no');
		tab.root.dataset.selected = 'yes';
		this.$(CodexAdminForm.selector).filter('.visible', element => element.classList.remove('visible'));
		tab.form.root.classList.add('visible');
	}

	removeTab(tab) {
		if (tab.root.dataset.selected === 'yes') {
			if (tab.root.nextElementSibling !== null) {
				this.selectTab(tab.root.nextElementSibling.controller);
			} else if (tab.root.previousElementSibling !== null) {
				this.selectTab(tab.root.previousElementSibling.controller);
			}
		}
		tab.form.root.remove();
		tab.root.remove();
	}

}

