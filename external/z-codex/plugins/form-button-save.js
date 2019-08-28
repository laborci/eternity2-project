import FormButtonPlugin from "../plugin/types/FormButtonPlugin";
import CodexAdminForm   from "../admin/form/brick";
import Ajax             from "zengular/core/ajax";

/**
 * @property {CodexAdminForm} form
 */
@FormButtonPlugin.register()
export default class FormButtonSave extends FormButtonPlugin {

	get label() { return 'Save';}
	get icon() { return 'fas fa-save';}
	get color() { return 'green';}
	action(event){
		let form = this.form;
		let data = {
			id: form.id,
			fields: form.collectFieldData()
		};
		form.showOverlay();
		Ajax.json('/' + form.urlBase + '/save-item', data).getJson
		.then(result => {
			if (result.status !== 200) {
				form.handlerError(result);
			}else{
				form.load(parseInt(result.id));
			}
		})
		.finally(() => {
			form.hideOverlay();
			form.reloadList();
		})
		;
	}
}
