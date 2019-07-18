import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";

@Brick.register('codex-admin-form', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
export default class CodexAdminForm extends Brick {


}

