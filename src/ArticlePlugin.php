<?php

namespace Miaoxing\Article;

class ArticlePlugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '图文管理';

    protected $description = '创建，编辑图文，可以在菜单，分类中显示';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $subCategories[] = [
            'parentId' => 'content',
            'name' => '图文分类管理',
            'url' => 'admin/article-categories',
        ];
    }

    public function onLinkToGetLinks(&$links, &$types)
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
                'url' => 'articles?categoryId=' . $category['id'],
            ];
        }
    }

    public function onLinkToRenderInput()
    {
        $this->view->display('@article/articles/linkTo.php');
    }

    public function onLinkToGetUrlArticle($linkTo)
    {
        return wei()->url('articles/%s', $linkTo['value']);
    }
}
