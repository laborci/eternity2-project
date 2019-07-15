import Brick from "zengular-brick";
import twig  from "./template.twig";
import "./style.less";
import Ajax  from "zengular-ajax";


@Brick.register('codex-form-frame', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexFormFrame extends Brick{


	onInitialize(){
	}

	route(data){
		if(this.name !== data.name){
			this.name = data.name;
			Ajax.request('/' + this.name + '/codexinfo').get().promise()
				.then(result => {
					this.codexinfo = result.json;
					this.setHeader();
					this.loadList();
				})
		}
	}

	onRender(){}

	setHeader(){
		this.find('[data-placeholder=icon]').classList.add(...this.codexinfo.header.icon.split(' '));
		this.find('[data-placeholder=title]').innerHTML = this.codexinfo.header.title;
	}
}

