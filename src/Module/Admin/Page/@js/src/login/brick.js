import Brick       from "zengular-brick";
import twig        from "./template.twig";
import "./style.less";

@Brick.register('login-app', twig)
@Brick.useAppEventManager()
@Brick.registerSubBricksOnRender()
export default class Todo extends Brick{

	onInitialize(){
	}

	onRender(){
	}

}