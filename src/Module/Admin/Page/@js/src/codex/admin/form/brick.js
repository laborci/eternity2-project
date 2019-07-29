import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";

@Brick.register('codex-admin-form', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminForm extends Brick {

	onInitialize() {
		this.sections = [];
		this.data = {};
	}

	createViewModel() {
		return {
			sections: this.sections
		}
	}

	load(id = null, urlBase = null){
		if(urlBase !== null) this.urlBase = urlBase;
		if(id !== null) this.id = id;

		Ajax.json.post('/' + this.urlBase + '/get-form-item/' + this.id)
			.then(result => result.json)
			.then(result => {
				this.tab.dataset.icon = result.descriptor.tabIcon;
				this.tab.dataset.label = result.data.fields[result.descriptor.labelField];
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
	}


}

