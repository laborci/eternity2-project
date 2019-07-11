<?php namespace Eternity2\Codex\Responder;

use Eternity2\WebApplication\Response\Responder\JsonResponder;

abstract class Menu extends JsonResponder {

	protected $menu = [];

	protected function respond() {
		$this->createMenu();
		return $this->menu;
	}

	abstract protected function createMenu();

	protected function addMenu($label = '', $icon = ''):MenuItem {
		$menu = new MenuItem($label, $icon);
		$this->menu[] = $menu;
		return $menu;
	}
}
