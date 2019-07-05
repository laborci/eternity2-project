<?php namespace Ghost;

class User extends Helper\GhostUser {

}

User::init();
User::$model->belongsTo('boss', User::class);
User::$model->hasMany('workers', User::class, 'bossId');
User::$model->hasAttachment('avatar');
User::$model->hasAttachment('gallery');