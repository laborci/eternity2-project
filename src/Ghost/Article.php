<?php namespace Ghost;

class Article extends Helper\GhostArticle {
}

Article::init();
Article::$model->belongsTo('author', User::class);