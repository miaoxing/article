<?php

namespace Miaoxing\Article;

class Plugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '文章管理';

    protected $description = '创建,编辑文章,可以在菜单,栏目中显示';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $subCategories['app-article'] = [
            'parentId' => 'app',
            'name' => '图文管理',
            'icon' => 'fa fa-list',
            'sort' => 1000,
        ];

        $navs[] = [
            'parentId' => 'app-article',
            'url' => 'admin/article/index',
            'name' => '图文管理',
        ];
    }

    public function onLinkToGetLinks(&$links, &$types, &$decorators)
    {
        $types['article'] = [
            'name' => '图文',
            'input' => 'custom',
            'sort' => 1100,
        ];

        $types['article-category'] = [
            'name' => '图文列表',
            'sort' => 1000,
        ];

        foreach (wei()->category()->notDeleted()->withParent('article')->desc('sort') as $category) {
            $links[] = [
                'typeId' => 'article-category',
                'name' => $category['name'],
                'url' => 'article?categoryId=' . $category['id'],
            ];
        }
    }

    public function onLinkToRenderInput()
    {
        $this->view->display('article:articles/linkTo.php');
    }

    public function onLinkToGetUrlArticle($linkTo)
    {
        return wei()->url('articles/%s', $linkTo['value']);
    }
}
