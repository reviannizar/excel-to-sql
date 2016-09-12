<?php

/*!
 *  Extended Config
 *  Copy Right (c)2016 
 *  author	: Abu Dzunnuraini
 *  email	: almprokdr@gmail.com
*/


$config = [
	'aliases' => [
		'jbiru'=> '@vendor/revian/jbiru',
	],
	'modules' => [
		'admin'=>['class' => 'jbiru\modules\admin\main',],
	],
];

return $config;
