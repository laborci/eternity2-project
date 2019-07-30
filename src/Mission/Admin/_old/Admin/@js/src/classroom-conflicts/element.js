import CustomElement from "phlex-custom-element";
import Ajax          from "phlex-ajax";
import ContextMenu   from "phlex-contextmenu";
import Modal         from "phlex-modal";

import twig from "./template.twig";
import css  from "./template.@.less";

@CustomElement.register('px-classroom-conflicts', {twig, css})
export default class Attachments extends CustomElement{

	constructor(){
		super();
		this.menu = new ContextMenu();
		this.menu.add('Download', 'fas fa-cloud-download-alt', (ctx) => {
			let win = window.open(ctx.dataset.url, '_blank');
			win.focus();
		});

		this.menu.add('Rename', 'fas fa-edit', (ctx) => {
			this.renameAttachment(ctx.dataset.filename, ctx.dataset.group);
		});
		this.menu.add('Delete', 'fal fa-trash-alt', (ctx) => {
			this.deleteAttachment(ctx.dataset.filename, ctx.dataset.group);
		});
	}

	render(){
		Ajax.request('/get-conflicts').get().promise().then((result) => {
			console.log(result.json);
			super.render(result.json);
			this.attachEventHandlers();
		});
	}

	attachEventHandlers(){

		this.attachEventHandler('[role=delete]', 'click', (event, target) => {
			if(confirm('Biztosan törölni szeretnéd a foglalást?\n(Értesítetted a felhasználót a törlésről?)')){
				Ajax.request('/delete-conflict/' + target.dataset.id).get().promise().then(() => {
					this.render();
				});
			}
		});
	}
}

