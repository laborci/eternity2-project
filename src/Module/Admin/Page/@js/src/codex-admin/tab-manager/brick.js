import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";
import pluginManager from "../../codex-plugin/plugin-manager";
import ListPreprocessPlugin from "../../codex-plugin/types/ListPreprocessPlugin";


@Brick.register('codex-admin-tab-manager', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminTabManager extends Brick {

	onRender() {
	}

	open(urlBase, id){
		console.log(urlBase, id);
	}

}

