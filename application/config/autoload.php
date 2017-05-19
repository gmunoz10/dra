<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('session', 'user_agent', 'pagination', 'form_validation');
$autoload['drivers'] = array();
$autoload['helper'] = array('language', 'url', 'form', 'captcha', 'util_helper');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array("mod_counter");