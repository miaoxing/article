<?php

namespace Miaoxing\Article\Controller;

use Miaoxing\Plugin\BaseController;

class ArticleLogs extends BaseController
{
    public function createAction($req)
    {
        $article = wei()->article()->findOneById($req['article_id']);

        $log = wei()->articleLogModel()->findOrInit([
            'user_id' => $this->curUser['id'],
            'article_id' => $article['id'],
        ]);

        $article->incr('pv');
        if ($log->isNew()) {
            $article->incr('uv');
        }

        $log->save();
        $article->save();

        $this->response->setHeader('Content-Type', 'image/gif');
        return base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
    }
}
