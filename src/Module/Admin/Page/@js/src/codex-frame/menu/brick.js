import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";

@Brick.register('codex-layout-menu', twig)
@Brick.useAppEventManager()
export default class CodexLayoutMenuBrick extends Brick {

	createViewModel() {
		return {
			title: this.dataset.title ? this.dataset.title : "Eternity Codex II",
			icon: this.dataset.icon ? this.dataset.icon : "fas fa-infinity",
			user: this.dataset.user,
			avatar: this.dataset.avatar
		}
	}

	onRender() {
		this.$('ul', (ul) => {
			ul.addEventListener('click', event => {
				let li = event.target.closest('li');
				if (li.classList.contains('has-submenu')) {
					li.classList.toggle('open');
				} else {
					this.appEventManager.fire('codex-menu-click', {option: li.dataset.option, action: li['menu-data']});
				}
			});
		});
		this.listen('.logout', 'click', event => {
			Ajax.request('/logout').post().do(()=> document.location.reload());
		});
	}

	addMenu(menu, parent = null) {
		menu.forEach(menuItem => {
			let li = document.createElement('li');
			let label = document.createElement('div');
			label.innerHTML = menuItem.label;
			if (menuItem.icon !== null) {
				let iconNode = document.createElement('i');
				menuItem.icon.split(' ').forEach(cls => iconNode.classList.add(cls));
				label.appendChild(iconNode);
			}
			li.appendChild(label);
			if (typeof menuItem.option !== 'undefined') li.dataset.option = menuItem.option;
			if (typeof menuItem.action !== 'undefined') li['menu-data'] = menuItem.action;

			if (typeof menuItem.submenu !== 'undefined' && parent === null) {
				let ul = document.createElement('ul');
				li.appendChild(ul);
				this.addMenu(menuItem.submenu, ul);
				li.classList.add('has-submenu');
			}

			if (parent === null) this.find('ul').appendChild(li);
			else parent.appendChild(li);
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

}