import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";

@Brick.register('codex-login', twig)
@Brick.useAppEventManager()
export default class Todo extends Brick {

	createViewModel() {
		return {
			icon: this.dataset.icon ? this.dataset.icon : "far fa-user-shield",
			title: this.dataset.title ? this.dataset.title : "Login",
			loginPlaceholder: this.dataset.loginPlaceholder ? this.dataset.loginPlaceholder : "login"
		}
	}

	onRender() {
		this.listen('button', 'click', event => this.login());
		this.listen('input', 'keydown', event =>{
			if(event.key === 'Enter' && !this.find('button').hasAttribute('disabled')) this.login()
		});
	}

	login(){
		this.find('button').setAttribute('disabled', true);

		const animtime = 500;
		let prewait = 0;
		if (this.findAll('footer.success.visible, footer.error.visible').length) {
			this.find('footer.success').classList.remove('visible');
			this.find('footer.error').classList.remove('visible');
			prewait = animtime;
		}

		this.sleep(prewait)
			.then(() => {
				this.find('footer.working').classList.add('visible');
			})
			.then(() => {
				return this.sleep(animtime);
			})
			.then(() => {
				return Ajax.request('/login').post({
					login: this.find('input[name=login]').value,
					password: this.find('input[name=password]').value
				}).promise();
			})
			.then(response => {
				this.find('footer.working').classList.remove('visible');
				return this.sleep(animtime).then(resolve => response)
			})
			.then(response => {
				if (response.status === 200) {
					this.find('footer.success').classList.add('visible');
					return this.sleep(animtime).then(() => {
						document.location.reload();
					})
				} else {
					this.find('footer.error').classList.add('visible');
					this.find('button').removeAttribute('disabled');
				}
			});
	}

	sleep(wait) {
		return new Promise((resolve) => setTimeout(resolve, wait));
	}

}
