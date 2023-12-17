<?php

namespace Miaoxing\Article;

use Miaoxing\Admin\Service\AdminMenu;
use Miaoxing\App\Service\PermissionMap;

class ArticlePlugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '图文管理';

    protected $description = '创建，编辑图文，可以在菜单，分类中显示';

    protected $code = 209;

    public function onAdminMenuGetMenus(AdminMenu $menu)
    {
        $content = $menu->child('content');

        $articles = $content->addChild()->setLabel('图文管理')->setUrl('admin/articles');
        $articles->addChild()->setLabel('添加')->setUrl('admin/articles/new');
        $articles->addChild()->setLabel('编辑')->setUrl('admin/articles/[id]/edit');
        $articles->addChild()->setLabel('删除')->setUrl('admin/articles/[id]/delete');

        $categories = $content->addChild()->setLabel('图文分类管理')->setUrl('admin/article-categories');
        $categories->addChild()->setLabel('添加')->setUrl('admin/article-categories/new');
        $categories->addChild()->setLabel('编辑')->setUrl('admin/article-categories/[id]/edit');
        $categories->addChild()->setLabel('删除')->setUrl('admin/article-categories/[id]/delete');
    }

    public function onPermissionGetMap(PermissionMap $map)
    {
        $map->prefix('admin/articles', static function (PermissionMap $map) {
            $map->addList('', [
                'GET api/admin/article-categories',
            ]);
            $map->addNew('', [
                'GET api/admin/article-categories',
            ]);
            $map->addEdit('', [
                'GET api/admin/article-categories',
            ]);
            $map->addDelete();
        });

        $map->prefix('admin/article-categories', static function (PermissionMap $map) {
            $map->addList();
            $map->addNew('', [
                'GET api/admin/article-categories',
            ]);
            $map->addEdit('', [
                'GET api/admin/article-categories',
            ]);
            $map->addDelete();
        });
    }
}
