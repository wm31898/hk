<?php

return [
    'pc' => [
        'class' => 'app\modules\pc\Module',
        'defaultRoute' => 'home',//设置默认控制器
        //'defaultAction' => 'test',//设置默认控制器
    ],
	'wfpcAdmin' => [
		'class' => 'app\modules\wfpcAdmin\Module',
		'defaultRoute' => 'home',//设置默认控制器
	],
];
