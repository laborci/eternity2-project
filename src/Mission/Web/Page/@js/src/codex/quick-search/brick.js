import Brick from "zengular-brick";
import "./style.less";

@Brick.register('codex-quick-search')
@Brick.useAppEventManager()
export default class DataTableBrick extends Brick{

	onInitialize(){
		this.root.setAttribute('placeholder', 'search');
		this.root.setAttribute('required', true);
		this.root.addEventListener('keyup', (event)=>{
			this.appEventManager.fire('quick-search', {keyword: this.root.value});
		});
	}

}