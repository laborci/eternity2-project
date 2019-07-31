import FormButtonPlugin from "../plugin/types/FormButtonPlugin";

@FormButtonPlugin.register()
export default class FormButtonDelete extends FormButtonPlugin {

	get label() { return 'Delete';}
	get icon() { return 'fas fa-times';}
	get color() { return 'red';}
	action(event){this.form.delete();}
	createButton() { return this.form.id ? super.createButton() : false; }
}
