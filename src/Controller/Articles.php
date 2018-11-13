<?php

namespace Miaoxing\Article\Controller;

class Articles extends \Miaoxing\Plugin\BaseController
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
            $this->page->setTitle($category['name']);
        }

        $tpl = isset($category) && $category['listTpl'] ? $category['listTpl'] : 'text';

        return get_defined_vars();
    }

    public function showAction($req)
    {
        $article = wei()->article()->cache()->findOneById($req['id']);
        if ($article->isLinkTo()) {
            return $this->response->redirect($article->getUrl());
        }

        $category = wei()->category()->withType('article')->findOrInitById($article['categoryId']);

        $like = wei()->articleLikeModel()->mine()->desc('id')->findOrInit(['article_id' => $article['id']]);

        $this->page
            ->setTitle($category['name'])
            ->hideHeader()
            ->hideFooter();

        switch ($req['_format']) {
            case 'json':
                return $this->suc(['data' => $article]);

            default:
                return get_defined_vars();
        }
    }
}
