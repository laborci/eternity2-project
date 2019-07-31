import FormButtonPlugin from "../plugin/types/FormButtonPlugin";

@FormButtonPlugin.register()
export default class FormButtonFiles extends FormButtonPlugin {

	get label() { return 'Files';}
	get icon() { return 'fa fa-folder';}
	get color() { return null;}
	action(event){this.form.showFiles();}
	createButton() { return this.form.id ? super.createButton() : false; }

}
