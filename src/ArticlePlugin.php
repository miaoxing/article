<?php

namespace Miaoxing\Article;

class ArticlePlugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '图文管理';

    protected $description = '创建，编辑图文，可以在菜单，分类中显示';

    protected $code = 209;

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $subCategories[] = [
            'parentId' => 'content',
            'name' => '图文管理',
            'url' => 'admin/articles',
        ];

        $subCategories[] = [
            'parentId' => 'content',
            'name' => '图文分类管理',
            'url' => 'admin/article-categories',
        ];
    }
}
