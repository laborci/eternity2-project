import Brick from "zengular-brick";
import twig  from "./template.twig";
import "./style.less";
import Ajax  from "zengular-ajax";
import CodexAdminList from "../list/brick";


@Brick.register('codex-admin-frame', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminFrame extends Brick{


	onInitialize(){
	}

	route(data){
		if(this.name !== data.name){
			this.name = data.name;
			Ajax.request('/' + this.name + '/codexinfo').get().promise()
				.then(result => {
					this.codexinfo = result.json;
					this.setHeader(result.json.header);
					this.loadList(result.json.list);
				})
		}
	}

	onRender(){}

	loadList(list){
		this.find(CodexAdminList.selector).controller.setup(list);
	}

	setHeader(header){
		this.find('[data-placeholder=icon]').classList.add(...header.icon.split(' '));
		this.find('[data-placeholder=title]').innerHTML = header.title;
	}
}

