<?php namespace Application\Module\Admin\Page;


use Eternity2\WebApplication\Responder\SmartPageResponder;

/**
 * @css /dist/admin/style.css
 * @js  /dist/admin/app.js
 * @title Admin
 * @bodyclass login
 * @template "@admin/Login.twig"
 */
class Login extends SmartPageResponder {}