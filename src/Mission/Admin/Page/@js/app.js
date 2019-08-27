import AdminApplication from "./src/codex/admin-app";
import "./src/plugins/loader";

new (class extends AdminApplication{})();