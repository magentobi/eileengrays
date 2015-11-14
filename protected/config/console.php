<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.utils.*',
	),
	'components' =>CMap::mergeArray(require(dirname(__FILE__) . '/components.php'),array(

	)),

    'params' => require(dirname(__FILE__) . '/params.php'),
);