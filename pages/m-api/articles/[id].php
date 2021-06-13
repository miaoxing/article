<?php

use Miaoxing\Article\Resource\ArticleResource;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;

return new class extends BaseController {
    protected $controllerAuth = false;

    public function get($req)
    {
        $article = ArticleModel::findOrFail($req['id']);

        $article->load('detail');

        return $article->toRet(ArticleResource::class);
    }
};
