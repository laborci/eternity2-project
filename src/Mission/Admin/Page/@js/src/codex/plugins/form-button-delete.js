import FormButtonPlugin from "../plugin/types/FormButtonPlugin";
import Modal            from "zengular-modal/src/modal";
import Ajax             from "zengular-ajax";

@FormButtonPlugin.register()
export default class FormButtonDelete extends FormButtonPlugin {

	get label() { return 'Delete';}
	get icon() { return 'fas fa-times';}
	get color() { return 'red';}
	createButton() { return this.form.id ? super.createButton() : false; }
	action(event) {
		let form = this.form;
		let modal = new Modal();
		modal.title = "DELETE ITEM";
		modal.body = `<i class="${form.icon}"></i> <b>${form.label}</b><br>Do you really want to delete this iteme?`;
		modal.addButton('Delete', () => {
			form.showOverlay();
			modal.close();
			Ajax.get('/' + form.urlBase + '/delete-item/' + form.id)
			.then((result) => {
				if (result.status !== 200) {
					form.handlerError(result);
				} else {
					form.tab.close();
				}
			})
			.finally(() => {
				form.hideOverlay();
				form.reloadList();
			})
			;
		}, 'danger');
		modal.addButton('Cancel', false);
		modal.show();
	}
}
