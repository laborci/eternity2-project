import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";
import pluginManager from "../../plugin/plugin-manager";
import FormButtonPlugin from "../../plugin/types/FormButtonPlugin";

@Brick.register('codex-admin-form', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminForm extends Brick {

	onInitialize() {
		this.sections = [];
		this.plugins = [];
		this.data = {};
	}

	createViewModel() {
		return {
			sections: this.sections,
			label: this.label,
			icon: this.icon,
			id: this.data.id
		}
	}

	load(id = null, urlBase = null){
		if(urlBase !== null) this.urlBase = urlBase;
		if(id !== null) this.id = id;

		Ajax.json.post('/' + this.urlBase + '/get-form-item/' + this.id)
			.then(result => result.json)
			.then(result => {
				this.label = result.data.fields[result.descriptor.labelField];
				this.icon = result.descriptor.formIcon;
				this.plugins = result.descriptor.plugins ? result.descriptor.plugins : [];
				this.tab.dataset.icon = result.descriptor.tabIcon;
				this.tab.dataset.label = this.label;
				this.data = result.data;
				this.sections = result.descriptor.sections;
				console.log(result);
				this.setup();
			});
	}

	onRender() {
		this.sections.forEach(section=>section.inputs.forEach(input=>{
			this.$$('input').filter(`[data-name=${input.field}`).node.controller.setOptions(input.options);
		}));

		for(let field in this.data.fields){
			this.$$('input').filter(`[data-name=${field}`).node.controller.value = this.data.fields[field];
		}

		let plugins = pluginManager.get(this.plugins, FormButtonPlugin);
		plugins.forEach(plugin=>{
			let button = document.createElement('span');
			button.classList.add(...plugin.icon.split(' '));
			button.dataset.label = plugin.label;
			if(plugin.color) button.style.color = plugin.color;
			button.addEventListener('click', event=>plugin.action(this, event));
			this.$$('buttons').node.appendChild(button);
		});
	}

	save(){
		let data = {
			id: this.id,
			fields: this.collectFieldData()
		}
		console.log(data);
	}

	collectFieldData(){
		let data = {};
		this.$$('input').each(input=>	data[input.dataset.name] = input.controller.value);
		return data;
	}

}

