import Brick   from "zengular-brick";
import "./style.less";

@Brick.useAppEventManager()
@Brick.renderOnConstruct(false)
@Brick.observeAttributes()
@Brick.addClass('codex-info-panel')
export default class InfoPanel extends Brick{}