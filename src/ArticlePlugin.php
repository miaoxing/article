<?php

namespace Miaoxing\Article;

use Miaoxing\Admin\Service\AdminMenu;

class ArticlePlugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '图文管理';

    protected $description = '创建，编辑图文，可以在菜单，分类中显示';

    protected $code = 209;

    public function onAdminMenuGetMenus(AdminMenu $menu)
    {
        $content = $menu->child('content');

        $articles = $content->addChild()->setLabel('图文管理')->setUrl('admin/articles')->setApis([
            'GET admin-api/article-categories',
        ]);
        $articles->addChild()->setUrl('admin/articles/new')->setLabel('添加');
        $articles->addChild()->setUrl('admin/articles/[id]/edit')->setLabel('编辑');

        $categories = $content->addChild()->setLabel('图文分类管理')->setUrl('admin/article-categories');
        $categories->addChild()->setUrl('admin/article-categories/new')->setLabel('添加');
        $categories->addChild()->setUrl('admin/article-categories/[id]/edit')->setLabel('编辑');
    }
}
