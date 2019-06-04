<?php namespace Eternity2\Codex\Responder;


class MenuItem {

	public $items = [];
	public $label;
	public $icon;

	public function __construct($label = '', $icon = '') {
		$this->label = $label;
	}

	public function addList($label, $icon, $url) {
		$item = ['label' => $label, 'icon' => $icon, 'action' => 'list', 'options'=>[]];
		$item[ 'options' ][ 'url' ] = $url;
		$this->items[] = $item;
		return $this;
	}

	public function addItem($label, $icon, $action, $options = []) {
		$item = ['label' => $label, 'icon' => $icon, 'action' => $action, 'options' => $options ];
		$this->items[] = $item;
		return $this;
	}

	public function get() {
		return [
			'label' => $this->label,
			'icon'  => $this->icon,
			'items' => $this->items,
		];
	}

};
