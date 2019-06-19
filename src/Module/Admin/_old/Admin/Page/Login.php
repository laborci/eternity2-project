<?php namespace Application\HTTP\Admin\Page;


use Eternity\Response\Responder\SmartPageResponder;

/**
 * @css /dist/admin/style.css
 * @js  /dist/admin/app.js
 * @title Admin
 * @bodyclass login
 * @template "@admin/Login.twig"
 */
class Login extends SmartPageResponder {}