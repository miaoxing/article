<?php

namespace Miaoxing\Article\Controller\Admin;

class ArticleCategory extends \Miaoxing\Category\Controller\Admin\Category
{
    protected $controllerName = '图文栏目管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];
}
