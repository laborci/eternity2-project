<?php namespace Ghost;

use Ghost\Helper\UserGhost;

class User extends UserGhost {


}

User::model('user');
User::$model->belongsTo('boss', User::class);
User::$model->hasMany('workers', User::class, 'bossId');
User::$model->hasAttachment('avatar');