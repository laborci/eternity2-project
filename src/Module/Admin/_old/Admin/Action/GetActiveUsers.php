<?php namespace Application\HTTP\Admin\Action;

use Entity\User\User;
use Eternity\Response\Responder\JsonResponder;
use RedFox\Database\Filter\Filter;

class GetActiveUsers extends JsonResponder {

	protected function respond() {

		$search = ($this->getPathBag()->get('search', false));
		$ids = ($this->getPathBag()->get('ids', false));

		return User::repository()
			->search(
				Filter::where("status='active'")->andIf($search !== false, "nick LIKE $1", Filter::like($search))
					->andIf($ids !== false, "id IN ($1)", Filter::explode($ids))
			)->select('id, nick')
			->asc('nick')->fetch(\PDO::FETCH_KEY_PAIR);
	}

}