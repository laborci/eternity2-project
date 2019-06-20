import Brick from "zengular-brick";
import twig  from "./template.twig";
import "./style.less";

@Brick.register('codex-layout-menu', twig)
@Brick.useAppEventManager()
export default class CodexLayoutMenuBrick extends Brick {

	onRender() {
		this.$('ul', (ul) => {
			ul.addEventListener('click', event => this.appEventManager.fire('menu-click', {option: event.target.dataset.option}));
		});
	}


	addMenuItem(label, option, icon = null) {
		let li = document.createElement('li');
		li.innerHTML = label;
		li.dataset.option = option;
		if (icon !== null) {
			let iconNode = document.createElement('i');
			icon.split(' ').forEach(cls => iconNode.classList.add(cls));
			li.appendChild(iconNode);
		}
		this.find('ul').appendChild(li);
	}

	setHeader(html){
		this.find('header').innerHTML = html;
	}

}