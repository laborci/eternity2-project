<?php

namespace Application\Service\Auth;

use Eternity2\Zuul\UserLoggerInterface;
use Ghost\UserLog;

class UserLogger implements UserLoggerInterface{

	const ADMINLOGIN = 'admin-login';
	const ADMINLOGOUT = 'admin-logout';

	public function log($userId, $type, $description = null){ UserLog::log($userId, $type, $description); }
}