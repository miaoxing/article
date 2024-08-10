<?php

use Miaoxing\Article\Resource\ArticleResource;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BasePage;

return new class extends BasePage {
    protected $controllerAuth = false;

    public function get($req)
    {
        $article = ArticleModel::findOrFail($req['id']);

        $article->load('detail');

        return $article->toRet(ArticleResource::class);
    }
};
