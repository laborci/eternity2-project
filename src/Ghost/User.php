<?php namespace Application\Ghost;

use Application\Ghost\Helper\UserGhost;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\GhostDesigner;

/**
 * @ghost-table user
 * @ghost-database DefaultDBConnection
 */
class User extends UserGhost{

	public $email;
	public $name;


}

User::initialize(\DefaultDBConnection::class, 'user',
	GhostDesigner::belongsTo('boss', User::class, 'bossId'),
	GhostDesigner::hasMany('workers', User::class, 'bossId'),
	GhostDesigner::protectField('email', 'setEmail', 'getEmail'),
);


