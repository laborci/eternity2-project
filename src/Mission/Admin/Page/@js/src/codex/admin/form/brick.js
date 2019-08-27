import Brick from "zengular/core/brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular/core/ajax";
import pluginManager from "../../plugin/plugin-manager";
import FormButtonPlugin from "../../plugin/types/FormButtonPlugin";
import Modal from "z-ui/modal/modal";

@Brick.register('codex-admin-form', twig)
@Brick.registerSubBricksOnRender()
export default class CodexAdminForm extends Brick {

	onInitialize() {
		this.sections = [];
		this.plugins = [];
		this.data = {};
		this.id = null;
	}

	createViewModel() {
		return {
			sections: this.sections,
			label: this.label,
			icon: this.icon,
			id: this.data.id
		}
	}

	load(id = null, urlBase = null) {
		if (urlBase !== null) this.urlBase = urlBase;
		if (id !== null) this.id = id;

		this.showOverlay();
		Ajax.get('/' + this.urlBase + '/get-form-item/' + (this.id===null ? 'new' : this.id))
			.then(result => {
				if (result.status !== 200) {
					this.handlerError(result, () => {this.tab.close();});
				} else {
					result = result.json;
					this.label = result.data.fields[result.descriptor.labelField];
					this.label = this.label ? this.label : 'new';
					this.icon = result.descriptor.formIcon;
					this.plugins = result.descriptor.plugins ? result.descriptor.plugins : [];
					this.tab.dataset.icon = result.descriptor.tabIcon;
					this.tab.dataset.label = this.label;
					this.tab.dataset.id = this.id;
					this.data = result.data;
					this.sections = result.descriptor.sections;
					this.setup();
				}
			})
			.finally(() => {
				this.hideOverlay();
			})
		;
	}

	onRender() {
		this.sections.forEach(section => section.inputs.forEach(input => {
			this.$$('input').filter(`[data-name=${input.field}`).node.controller.setOptions(input.options);
		}));

		for (let field in this.data.fields) {
			this.$$('input').filter(`[data-name=${field}`).node.controller.value = this.data.fields[field];
		}

		let plugins = pluginManager.get(this.plugins, FormButtonPlugin, this);
		plugins.forEach(plugin => {
			let button = plugin.createButton();
			if (button) this.$$('buttons').node.appendChild(button);
		});
	}

	handlerError(result, cb = null) {
		let message = `Some unknown error occured: ${result.statusText} (${result.status})`;
		if (typeof result.json?.message === "string") message = result.json.message;
		let modal = new Modal();
		modal.title = "ERROR";
		modal.body = message;
		modal.addButton('Ok', false, 'danger');
		modal.onClose = cb;
		modal.show();
	}

	collectFieldData() {
		let data = {};
		this.$$('input').each(input => data[input.dataset.name] = input.controller.value);
		return data;
	}

	reloadList() { this.appEventManager.fire('RELOAD-LIST', {urlBase: this.urlBase});}

	showOverlay() { this.$$('overlay').node.classList.add('visible');}
	hideOverlay() { this.$$('overlay').node.classList.remove('visible');}
}

