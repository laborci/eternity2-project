import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";

@Brick.register('codex-admin-form', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminForm extends Brick {


	load(id, urlBase){
		this.urlBase = urlBase;
		this.id = id;

		Ajax.json.post('/' + this.urlBase + '/get-form-item/' + this.id)
			.then(result => result.json)
			.then(result => {
				console.log(result);
			});
	}


}

