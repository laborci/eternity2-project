import Brick from "zengular-brick";
import twig from "./template.twig";
import "./style.less";
import Ajax from "zengular-ajax";
import pluginManager from "../../codex-plugin/plugin-manager";
import ListPreprocessPlugin from "../../codex-plugin/types/ListPreprocessPlugin";


@Brick.register('codex-admin-list', twig)
@Brick.registerSubBricksOnRender()
@Brick.useAppEventManager()
@Brick.renderOnConstruct(false)
export default class CodexAdminList extends Brick {

	onInitialize() {
		this.page = 1;
	}

	setup(args) {
		this.listDescription = args;
		super.setup();
	}

	createViewModel() {
		return this.listDescription;
	}

	onRender() {
		Ajax.request('/' + this.listDescription.urlBase + '/get-list/' + this.page).post().promise()
			.then(result => result.json)
			.then(result => {

				this.find('[data-for=count]').innerHTML = (result.page-1)*this.listDescription.pageSize+1 + '-' + (result.page*this.listDescription.pageSize) + ' / '+result.count;

				let plugins = pluginManager.get(this.listDescription.plugins, ListPreprocessPlugin);
				let tbody = this.find('tbody');
				this.listen('tbody', 'click', event=>{
					console.log(event.target.parentNode.dataset.id)
				});
				tbody.innerHTML = '';
				result.rows.forEach(row => {
					let tr = document.createElement('tr');
					tr.dataset.id = row[this.listDescription.idField];
					plugins.forEach(plugin => { plugin.preprocess(row);});
					this.listDescription.fields.forEach(field => {
						if (field.visible) {
							let td = document.createElement('td');
							td.innerHTML = typeof row[field.name] !== 'undefined' ? row[field.name] : '-';
							tr.appendChild(td);
						}
					});
					tbody.appendChild(tr);
				});
			});
	}

}

