<?php

use Miaoxing\Article\Resource\ArticleResource;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BasePage;

return new class () extends BasePage {
    protected $controllerAuth = false;

    public function get($req)
    {
        $articles = ArticleModel::desc('sort')
            ->desc('id')
            ->reqPage()
            ->whereIf($req['categoryId'], 'categoryId', $req['categoryId'])
            ->all();

        return $articles->toRet(ArticleResource::class);
    }
};
