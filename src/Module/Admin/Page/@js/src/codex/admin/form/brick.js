import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";

@Brick.register('codex-admin-form', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminForm extends Brick {


	load(id = null, urlBase = null){
		if(urlBase !== null) this.urlBase = urlBase;
		if(id !== null) this.id = id;

		Ajax.json.post('/' + this.urlBase + '/get-form-item/' + this.id)
			.then(result => result.json)
			.then(result => {
				//this.setIcon(result.descriptor)
				this.tab.dataset.icon = result.descriptor.tabIcon;
				this.tab.dataset.label = result.data.data[result.descriptor.labelField];
			});
	}


}

