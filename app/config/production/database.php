<?php

return array(

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'freeflow.me',
			'username'  => $_SERVER['DB_USER'],
			'password'  => $_SERVER['DB_PASS'],
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
	)
);