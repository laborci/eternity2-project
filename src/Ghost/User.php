<?php namespace Application\Ghost;

use Application\Ghost\Helper\UserGhost;

class User extends UserGhost {


}

User::initialize(\DefaultDBConnection::class, 'user');

