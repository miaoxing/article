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

        $tpl = $category && $category['listTpl'] ? $category['listTpl'] : 'text';

        return $this->view->render('article:articles/lists/' . $tpl . '.php', get_defined_vars());
    }

    public function showAction($req)
    {
        $article = wei()->article()->cache()->findOneById($req['id']);

        $category = wei()->category()->withType('article')->findOneById($article['categoryId']);
        $htmlTitle = $category['name'];

        $this->pageConfig['displayHeader'] = false;
        $this->pageConfig['displayFooter'] = false;

        switch ($req['_format']) {
            case 'json':
                return $this->suc(['data' => $article]);

            default:

                return get_defined_vars();
        }
    }
}
