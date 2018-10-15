<?php

namespace Miaoxing\Article\Controller;

use Miaoxing\Plugin\BaseController;

class ArticleLikes extends BaseController
{
    public function toggleAction($req)
    {
        $article = wei()->article()->findOneById($req['articleId']);

        $like = wei()->articleLikeModel()->mine()
            ->desc('id')
            ->findOrInit(['article_id' => $article['id']]);

        wei()->articleLikeModel()->save([
            'userId' => wei()->curUserV2->id,
            'articleId' => $article['id'],
            'type' => !$like->type,
        ]);

        $article->incr('likeNum', $like->type ? -1 : 1)->save();

        return $this->suc();
    }
}
