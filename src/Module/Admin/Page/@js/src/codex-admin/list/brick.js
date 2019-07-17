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

		this.fields = args.fields;
		this.pageSize = args.pageSize;
		this.idField = args.idField;
		this.urlBase = args.urlBase;
		this.plugins = args.plugins;

		this.fields.forEach(field => {
			if (field.visible && field.sortable && this.sort.field === null) this.sort.field = field.name;
		});

		super.setup();
	}

	bindPagingDisplay(pagingDisplay) {this.pagingDisplay = pagingDisplay;}

	createViewModel() {
		return {
			fields: this.fields
		};
	}

	onRender() {

		this.listen('tbody', 'click', event => {
			console.log(event.target.parentNode.dataset.id)
		});


		this.listen('[data-for=pager]', 'input', event => {
			let page = event.target.value;
			this.pagingDisplay.current.innerHTML = (page - 1) * this.pageSize + 1 + '-' + Math.min(page * this.pageSize, this.count);
		});
		this.listen('[data-for=pager]', 'change', event => this.load(event.target.value));
		this.listen('[data-for=step-page-right]', 'click', event => this.load(this.page + 1));
		this.listen('[data-for=step-page-left]', 'click', event => this.load(this.page - 1));


		this.listen('.sortable', 'click', event => {
			if (this.loading) return;
			if (this.sort.field === event.target.dataset.field) {
				this.sort.dir = this.sort.dir === 'asc' ? 'desc' : 'asc';
			} else {
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

	renderSortingIcons() {
		this.$('.sort--1', elem => elem.classList.remove('sort--1'));
		this.$('.sort-1', elem => elem.classList.remove('sort-1'));
		this.find('.sortable[data-field=' + this.sort.field + ']').classList.add(this.sort.dir === 'asc' ? 'sort-1' : 'sort--1');
	}

	load(page = null) {
		if (page === null) page = this.page;
		if (this.loading) return;

		this.loading = true;

		Ajax.request('/' + this.urlBase + '/get-list/' + page).postJSON({sort: this.sort.field ? this.sort : null}).promise()
			.then(result => result.json)
			.then(result => {
				console.log(result);
				this.page = parseInt(result.page);
				this.count = result.count;

				this.pagingDisplay.current.innerHTML = (result.page - 1) * this.pageSize + 1 + '-' + (Math.min(result.page * this.pageSize, this.count));
				this.pagingDisplay.count.innerHTML = result.count;

				let pages = Math.ceil(result.count / this.pageSize);
				this.find('.slider input').setAttribute('max', pages);
				this.find('.slider input').value = result.page;
				if (this.page === 1) this.find(".left").classList.add('unavailable');
				else this.find(".left").classList.remove('unavailable');
				if (this.page === pages) this.find(".right").classList.add('unavailable');
				else this.find(".right").classList.remove('unavailable');


				this.renderContent(result.rows);
				this.loading = false;
			});
	}

	renderContent(rows) {
		let plugins = pluginManager.get(this.plugins, ListPreprocessPlugin);
		let tbody = this.find('tbody');
		tbody.innerHTML = '';
		rows.forEach(row => {
			let tr = document.createElement('tr');
			tr.dataset.id = row[this.idField];
			plugins.forEach(plugin => { plugin.preprocess(row);});
			this.fields.forEach(field => {
				if (field.visible) {
					let td = document.createElement('td');
					td.innerHTML = typeof row[field.name] !== 'undefined' ? row[field.name] : '-';
					tr.appendChild(td);
				}
			});
			tbody.appendChild(tr);
		});
	}

}

