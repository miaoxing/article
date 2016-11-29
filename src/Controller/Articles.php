<?php

namespace Miaoxing\Article\Controller;

class Articles extends \miaoxing\plugin\BaseController
{
    protected $guestPages = ['articles'];

    public function indexAction($req)
    {
        $articles = wei()->article()
            ->cache()
            ->desc('sort')
            ->desc('id');

        if ($req['categoryId']) {
            $category = wei()->category()->withType('article')->findOneById($req['categoryId']);
            $categoryIds = $category->getChildrenIds();
            $articles->andWhere(['categoryId' => $categoryIds]);
            $headerTitle = $category['name'];
            $htmlTitle = $category['name'];
        }

        return $this->view->render('article:articles/lists/' . ($category && $category['listTpl'] ? $category['listTpl'] : 'text') . '.php', get_defined_vars());
    }

    public function showAction($req)
    {
        $article = wei()->article()->cache()->findOneById($req['id']);

        // 只显示头部的标题,不显示菜单上的标题
        $headerTitle = $article['title'];

        $category = wei()->category()->withType('article')->findOneById($article['categoryId']);
        $htmlTitle = $category['name'];

        $this->pageConfig['displayFooter'] = false;
        return get_defined_vars();
    }
}
