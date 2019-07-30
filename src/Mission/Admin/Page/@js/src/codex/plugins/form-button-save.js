import FormButtonPlugin from "../plugin/types/FormButtonPlugin";

@FormButtonPlugin.register()
export default class FormButtonSave extends FormButtonPlugin {

	get label() { return 'Save';}
	get icon() { return 'fas fa-save';}
	get color() { return 'green';}
	action(form, event){form.save();}
}
