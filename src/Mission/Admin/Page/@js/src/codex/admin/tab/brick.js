import Brick from "zengular/core/brick";
import twig  from "./template.twig";
import "./style.less";

@Brick.register('codex-admin-tab', twig)
@Brick.registerSubBricksOnRender()
@Brick.observeAttributes(['data-label', 'data-icon', 'data-selected'])
export default class CodexAdminTab extends Brick {

	onInitialize() {
		this.listen(null, 'click', event => {
			if (this.dataset.selected !== 'yes') this.appEventManager.fire('TAB-SELECTED');
		});
		this.root.classList.add('closed');
	}

	createViewModel() {
		return {
			label: this.dataset.label,
			icon: this.dataset.icon,
			selected: this.dataset.selected
		};
	}

	onAttributeChange() {this.setup();}

	onRender() {
		this.root.setAttribute('title', this.dataset.label);
		this.$$('close').listen('click', event => {
			this.close();
			event.stopPropagation();
		});
		window.requestAnimationFrame(() => this.root.classList.remove('closed'));
	}

	close() {
		this.root.classList.add('closed');
		setTimeout(() => this.appEventManager.fire('TAB-CLOSED'), 300);
	}

}

