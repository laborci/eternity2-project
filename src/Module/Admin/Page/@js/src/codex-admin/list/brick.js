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
		this.sort = {field: null, dir: 'asc'};
	}

	setup(args) {
		this.listDescription = args;
		this.listDescription.fields.forEach(field => {
			if (field.visible && field.sortable && this.sort.field === null) this.sort.field = field.name;
		});
		super.setup();
	}

	createViewModel() {return this.listDescription;}

	onRender() {

		this.listen('.slider input', 'input', event => {
			let page = event.target.value;
			this.find('[data-for=current]').innerHTML = (page - 1) * this.listDescription.pageSize + 1 + '-' + page * this.listDescription.pageSize;
		});
		this.listen('.slider input', 'change', event => this.load(event.target.value));
		this.listen('.slider .right:not(.unavailable)', 'click', event => this.load(this.page + 1));
		this.listen('.slider .left:not(.unavailable)', 'click', event => this.load(this.page - 1));
		this.listen('tbody', 'click', event => {
			console.log(event.target.parentNode.dataset.id)
		});
		this.listen('.sortable', 'click', event=>{
			if(this.loading) return;
			if(this.sort.field === event.target.dataset.field){
				this.sort.dir = this.sort.dir ==='asc' ? 'desc' : 'asc';
			}else{
				this.sort = {
					field: event.target.dataset.field,
					dir: 'asc'
				}
			}
			this.renderSortingIcons();
			this.load();
		});
		this.renderSortingIcons();
		this.load(this.page);
	}

	renderSortingIcons(){
		this.$('.sort--1', elem=>elem.classList.remove('sort--1'));
		this.$('.sort-1', elem=>elem.classList.remove('sort-1'));
		this.find('.sortable[data-field='+this.sort.field+']').classList.add(this.sort.dir==='asc' ? 'sort-1' : 'sort--1');
	}

	load(page = null) {
		if(page === null) page = this.page;
		if (this.loading) return;
		this.loading = true;
		Ajax.request('/' + this.listDescription.urlBase + '/get-list/' + page).postJSON({sort: this.sort.field ? this.sort : null}).promise()
			.then(result => result.json)
			.then(result => {
				this.page = parseInt(result.page);

				this.find('[data-for=current]').innerHTML = (result.page - 1) * this.listDescription.pageSize + 1 + '-' + (result.page * this.listDescription.pageSize);
				this.find('[data-for=count]').innerHTML = result.count;
				let pages = Math.ceil(result.count / this.listDescription.pageSize);
				this.find('.slider input').setAttribute('max', pages);
				this.find('.slider input').value = result.page;
				if (this.page === 1) this.find(".left").classList.add('unavailable');
				else this.find(".left").classList.remove('unavailable');
				if (this.page === pages) this.find(".right").classList.add('unavailable');
				else this.find(".right").classList.remove('unavailable');

				let plugins = pluginManager.get(this.listDescription.plugins, ListPreprocessPlugin);
				let tbody = this.find('tbody');

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
				this.loading = false;
			});
	}

}

