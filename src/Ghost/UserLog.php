<?php namespace Ghost;

class UserLog extends Helper\GhostUserLog {

	public static function authLog($userId, $event, $details){
		$log = new static();
		$log->datetime = new \DateTime();
		$log->userId = $userId;
		$log->event = $event;
		$log->details = $details;
		$log->save();
	}

}

UserLog::init();
UserLog::$model->belongsTo('user', User::class);