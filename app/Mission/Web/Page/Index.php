<?php namespace Application\Mission\Web\Page;


use Eternity2\Module\SmartPageResponder\Responder\SmartPageResponder;
/**
 * @template "@web/Index.twig"
 * @title "Index"
 * @bodyclass "mypage"
 * @js "/~web/js/app.js"
 * @css "/~web/css/style.css"
 */
class Index extends SmartPageResponder {

	protected $connection;

}