<?php namespace Ghost;

use Ghost\Helper\UserGhost;

class User extends UserGhost {


}

User::model('user');
User::$model->belongsTo('boss', User::class);
User::$model->hasMany('workers', User::class, 'bossId');
User::$model->hasAttachment('avatar');

$user = User::pick(1);


class AttachmentCollection implements \ArrayAccess{

	protected $attachments = null;

	public function __construct(){

	}

	public function offsetExists($offset){

	}

	public function offsetGet($offset){

	}

	public function offsetSet($offset, $value){

	}

	public function offsetUnset($offset){

	}

}