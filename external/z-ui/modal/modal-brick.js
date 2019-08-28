import Modal from "./modal";
import Brick from "zengular/core/brick";

export default class ModalBrick extends Brick{

	static createModal(parent = null){
		let modal = new Modal();
		if(parent !== null) modal.parent = parent;
		modal.body = this.create();
		modal.body.controller.modal = modal;
		modal.body.controller.initializeModal(modal);
		modal.onShow = (args) => { modal.body.controller.onShowModal(args); };
		modal.onClose = () => { return modal.body.controller.onCloseModal(); };
		return modal;
	};

	onShowModal(args){ this.setup(args);}

	onCloseModal(){}

}