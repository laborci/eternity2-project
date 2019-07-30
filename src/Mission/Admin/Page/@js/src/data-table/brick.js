import Brick   from "zengular-brick";
import twig    from "./template.twig";
import "./style.less";

@Brick.register('codex-data-table', twig)
@Brick.useAppEventManager()
@Brick.renderOnConstruct(false)
@Brick.cleanOnConstruct(false)
export default class DataTableBrick extends Brick{

	onInitialize(){
		this.searchKeyword = null;
	}

	createViewModel(){

		this.sort();

		return {
			options: this.options,
			columns: this.columns,
			data:    this.data
		};
	}

	init(descriptor){
		this.options = descriptor.options;
		this.fields = {};
		this.columns = descriptor.columns;
		this.columns.forEach(column => {
			if(typeof column.datatype === 'undefined')column.datatype = 'string';
			if(typeof column.getter === 'undefined')column.getter = row => row[column.field];
			this.fields[column.field] = column;
		});

		this.dataSet = [];
		descriptor.data.forEach(row => {
			let newRow = {};
			newRow[this.options.idField] = row[this.options.idField];
			this.columns.forEach(col => {
				newRow[col.field] = col.getter(row);
				if(col.datatype === 'number') newRow[col.field] = parseFloat(newRow[col.field]);
			});
			this.dataSet.push(newRow);
		});
		this.data = this.dataSet;
		this.setup();
	}

	onRender(){
		this.$('tr', tr => tr.addEventListener('click', (event) => {
			if(typeof event.currentTarget.dataset !== 'undefined'&& typeof event.currentTarget.dataset.id !=='undefined'){
				this.appEventManager.fire(this.options.eventName, {id: event.currentTarget.dataset.id});
			}
		}));

		this.$('th', th=>th.addEventListener('click', event=>{
			this.options.sort.field = event.target.dataset.field;
			this.setup();
		}));
	}

	sort(){
		if(typeof this.options.sort !== 'undefined'){
			let order = this.options.sort.order === 'asc' ? 1 : -1;
			let sort = this.options.sort.field;
			console.log(sort, order);
			this.data = this.data.sort((a, b) => (a[sort] > b[sort]) ? order : -1 * order);
		}
	}

	search(search, fields){
		if(search.length < 3){
			search = null;
			if(this.searchKeyword !== null){
				this.searchKeyword = null;
				this.data = this.dataSet;
				this.setup();
			}
			return;
		}
		let data = [];
		search = search.toLowerCase();
		this.searchKeyword = search;
		this.dataSet.forEach(row => {
			let found = false;
			fields.forEach(field => {
				if(typeof row[field] === 'string' && row[field].toLowerCase().indexOf(search) !== -1)
					found = true;
			});
			if(found) data.push(row);
		});
		this.data = data;
		this.setup();
	}

}