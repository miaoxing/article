<?php

namespace MiaoxingDoc\Article {

    /**
     * @property    \Miaoxing\Article\Service\Article $article
     * @method      \Miaoxing\Article\Service\Article|\Miaoxing\Article\Service\Article[] article()
     *
     * @property    \Miaoxing\Article\Service\ArticleLikeModel $articleLikeModel ArticleLikeModel
     * @method      \Miaoxing\Article\Service\ArticleLikeModel|\Miaoxing\Article\Service\ArticleLikeModel[] articleLikeModel()
     *
     * @property    \Miaoxing\Article\Service\ArticleLogModel $articleLogModel 图文日志
     * @method      \Miaoxing\Article\Service\ArticleLogModel|\Miaoxing\Article\Service\ArticleLogModel[] articleLogModel()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return MiaoxingDoc\Article\AutoComplete
     */
    function wei()
    {
    }

    /** @var Miaoxing\Article\Service\Article $article */
    $article = wei()->article;

    /** @var Miaoxing\Article\Service\ArticleLikeModel $articleLikeModel */
    $articleLike = wei()->articleLikeModel();

    /** @var Miaoxing\Article\Service\ArticleLikeModel|Miaoxing\Article\Service\ArticleLikeModel[] $articleLikeModels */
    $articleLikes = wei()->articleLikeModel();

    /** @var Miaoxing\Article\Service\ArticleLogModel $articleLogModel */
    $articleLog = wei()->articleLogModel();

    /** @var Miaoxing\Article\Service\ArticleLogModel|Miaoxing\Article\Service\ArticleLogModel[] $articleLogModels */
    $articleLogs = wei()->articleLogModel();
}
