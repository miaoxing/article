<?php

use Miaoxing\Article\Resource\ArticleResource;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;

return new class () extends BaseController {
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
