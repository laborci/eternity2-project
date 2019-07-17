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

	createViewModel() {
		return {
			fields: this.fields
		};
	}

	onRender() {

		this.$$('list').listen('click', event => {
			this.appEventManager.fire('ITEM-SELECTED', {id: event.target.closest('tr').dataset.id});
		});


		this.$$('pager-slider').listen('input', event => {
			let page = event.target.value;
			this.appEventManager.fire('PAGING-CHANGED', {page: page, pageSize: this.pageSize, count: this.count});
		});

		this.$$('pager-slider').listen('change', event => this.load(event.target.value));

		this.$$('step-page-right').listen('click', event =>
			this.$$('pager-slider', slider => {
				slider.value++;
				this.load(slider.value);
			})
		);

		this.$$('step-page-left').listen('click', event =>
			this.$$('pager-slider', slider => {
				slider.value--;
				this.load(slider.value);
			})
		);


		this.$$('sortable').listen('click', event => {
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
		this.$$('sortable', elem => elem.classList.remove('sort-asc', 'sort-desc'));
		this.$$('sortable').filter(`[data-field=${this.sort.field}]`, elem => elem.classList.add('sort-' + this.sort.dir));
	}

	load(page = null) {

		if (page === null) page = this.page;
		if (this.loading) return;

		this.loading = true;

		Ajax.request('/' + this.urlBase + '/get-list/' + page).postJSON({sort: this.sort.field ? this.sort : null}).promise()
			.then(result => result.json)
			.then(result => {
				this.page = parseInt(result.page);
				this.count = result.count;

				this.appEventManager.fire('PAGING-CHANGED', {page: this.page, pageSize: this.pageSize, count: this.count});

				let pages = Math.ceil(result.count / this.pageSize);
				this.$$('pager-slider').get().setAttribute('max', pages);
				this.$$('pager-slider').get().value = result.page;


				this.$$('step-page-left', stepper => {
					if (this.page === 1) stepper.classList.add('unavailable');
					else stepper.classList.remove('unavailable');
				});

				this.$$('step-page-right', stepper => {
					if (this.page === pages) stepper.classList.add('unavailable');
					else stepper.classList.remove('unavailable');
				});

				this.renderContent(result.rows);
				this.loading = false;
			});
	}

	renderContent(rows) {
		let plugins = pluginManager.get(this.plugins, ListPreprocessPlugin);
		let tbody = this.$$('list').get();
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

