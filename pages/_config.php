<?php

return [
    '/admin' => [
        'name' => '首页',

        '/article-categories' => [
            'name' => '图文分类管理',
            'apis' => [
                [
                    'method' => 'GET',
                    'page' => 'admin-api/article-categories',
                ],
            ],

            '/new' => [
                'name' => '添加',
            ],

            '/[id]' => [
                '/edit' => [
                    'name' => '编辑',
                ],
            ],
        ],
    ],
];
