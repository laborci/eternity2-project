import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import "../tab/brick";
import CodexAdminTab from "../tab/brick";
import CodexAdminForm from "../form/brick";


@Brick.register('codex-admin-tab-manager', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminTabManager extends Brick {

	onInitialize() {
		this.appEventManager.listen('TAB-SELECTED', event => { this.selectTab(event.source);});
		this.appEventManager.listen('TAB-CLOSED', event => { this.removeTab(event.source);});
	}

	onRender() {
	}

	open(urlBase, id) {
		let tab = this.find(CodexAdminTab.selector+`[data-id="${id}"][data-type="${urlBase}"]`);
		if(tab === null){
			tab = CodexAdminTab.create('div', true);
			tab.dataset.id = id;
			tab.dataset.type = urlBase;
			tab.dataset.icon = 'fas fa-infinity';
			tab.dataset.label = '...';
			this.$$('tabs').node.appendChild(tab);

			let form = CodexAdminForm.create('div', true);

			tab.controller.form = form.controller;
			form.controller.tab = tab.controller;

			form.controller.load(id, urlBase);
			this.$$('forms').node.appendChild(form);
		}
		this.selectTab(tab.controller);
	}

	selectTab(tab) {
		this.$(CodexAdminTab.selector).filter('[data-selected=yes]', tab => tab.dataset.selected = 'no');
		tab.root.dataset.selected = 'yes';
		this.$(CodexAdminForm.selector).filter('.visible', element=>element.classList.remove('visible'));
		tab.form.root.classList.add('visible');
	}

	removeTab(tab){
		if(tab.root.dataset.selected === 'yes') {
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

