import CustomElement  from "phlex-custom-element";
import twig           from "./template.twig";
import css            from "./template.@.less";
import InputDecorator from "phlex-codex/lib/inputs/InputDecorator";

@CustomElement.register('px-input-rule-editor', {twig, css})
@InputDecorator
export default class extends CustomElement{

	get templateData(){ return this.data; };

	render(){
		console.log(this.data);
		var data = {
			data: this.data,
			days: ['Hétfő', 'Kedd', 'Szerda', 'Csürörtök', 'Péntek', 'Szombat', 'Vasárnap']
		};
		super.render();
		this.attachEventHandlers();
	}

	updateValues(){
		this.root.querySelectorAll('.day').forEach(day => {
			if(day.querySelector('[type=checkbox]').checked){
				var from = parseInt(day.querySelector('[name=from]').value);
				var to = parseInt(day.querySelector('[name=to]').value);
				day.querySelector('span').innerHTML =
					(Math.floor(from / 4)).toString().padStart(2, '0') + ':' +
					((from % 4) * 15).toString().padStart(2, '0') + ' - ' +
					(Math.floor((to + 1) / 4)).toString().padStart(2, '0') + ':' +
					(((to + 1) % 4) * 15).toString().padStart(2, '0');
			}else{
				day.querySelector('span').innerHTML = 'Nem elérhető';
			}
		});
	}

	attachEventHandlers(){
		this.root.querySelectorAll('.day').forEach(day => {
			var from = day.querySelector('[name=from]');
			var to = day.querySelector('[name=to]');

			day.querySelector('[type=checkbox]').addEventListener('change', event => {
				if(!event.target.checked){
					from.disabled = true;
					to.disabled = true;
				}else{
					from.disabled = false;
					to.disabled = false;
				}
				this.updateValues();
			});

			from.addEventListener('change', event => {
				if(from.value > to.value){
					to.value = from.value;
				}
				this.updateValues();
			});

			to.addEventListener('change', event => {
				if(from.value > to.value){
					from.value = to.value;
				}
				this.updateValues();
			});
		});
	}

	set value(value){
		this.root.querySelectorAll('.day').forEach(day => {
			var from = day.querySelector('[name=from]');
			var to = day.querySelector('[name=to]');
			var checkbox = day.querySelector('[type=checkbox]');

			if(value.days[day.dataset.day] === false){
				checkbox.checked = false;
				from.disabled = true;
				to.disabled = true;
			}else{
				checkbox.checked = true;
				from.disabled = false;
				to.disabled = false;
				from.value = value.days[day.dataset.day].start;
				to.value = value.days[day.dataset.day].end;
			}
		});
		this.updateValues();
	}

	get value(){
		var data = {days: []};
		this.root.querySelectorAll('.day').forEach(day => {
			var from = day.querySelector('[name=from]');
			var to = day.querySelector('[name=to]');
			var checkbox = day.querySelector('[type=checkbox]');

			if(checkbox.checked === false){
				data.days[day.dataset.day] = false;
			}else{
				data.days[day.dataset.day] = {
					start: parseInt(from.value),
					end:   parseInt(to.value)
				};
			}
		});
		return data;
	}

}