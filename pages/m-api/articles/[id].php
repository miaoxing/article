<?php

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;

return new class extends BaseController {
    protected $controllerAuth = false;

    public function get($req)
    {
        $article = ArticleModel::findOrFail($req['id']);

        return suc([
            'data' => [
                'id' => $article->id,
                'categoryId' => $article->categoryId,
                'title' => $article->title,
                'author' => $article->author,
                'cover' => $article->cover,
                'intro' => $article->intro,
                'likeNum' => $article->likeNum,
                'createdAt' => $article->createdAt,
                'updatedAt' => $article->updatedAt,
                'detail' => [
                    'showCover' => $article->detail->showCover,
                    'content' => $article->detail->content,
                ],
            ],
        ]);
    }
};
