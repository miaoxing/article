<?php

/**
 * @property    Miaoxing\Article\Service\ArticleCategoryModel $articleCategoryModel
 * @method      Miaoxing\Article\Service\ArticleCategoryModel articleCategoryModel() 返回当前对象
 */
class ArticleCategoryModelMixin {
}

/**
 * @property    Miaoxing\Article\Service\ArticleDetailModel $articleDetailModel
 * @method      Miaoxing\Article\Service\ArticleDetailModel articleDetailModel() 返回当前对象
 */
class ArticleDetailModelMixin {
}

/**
 * @property    Miaoxing\Article\Service\ArticleLikeModel $articleLikeModel ArticleLikeModel
 * @method      Miaoxing\Article\Service\ArticleLikeModel articleLikeModel() 返回当前对象
 */
class ArticleLikeModelMixin {
}

/**
 * @property    Miaoxing\Article\Service\ArticleLogModel $articleLogModel 图文日志
 * @method      Miaoxing\Article\Service\ArticleLogModel articleLogModel() 返回当前对象
 */
class ArticleLogModelMixin {
}

/**
 * @property    Miaoxing\Article\Service\ArticleModel $articleModel
 * @method      Miaoxing\Article\Service\ArticleModel articleModel() 返回当前对象
 */
class ArticleModelMixin {
}

/**
 * @mixin ArticleCategoryModelMixin
 * @mixin ArticleDetailModelMixin
 * @mixin ArticleLikeModelMixin
 * @mixin ArticleLogModelMixin
 * @mixin ArticleModelMixin
 */
class AutoCompletion {
}

/**
 * @return AutoCompletion
 */
function wei()
{
    return new AutoCompletion;
}

/** @var Miaoxing\Article\Service\ArticleCategoryModel $articleCategory */
$articleCategory = wei()->articleCategoryModel;

/** @var Miaoxing\Article\Service\ArticleCategoryModel|Miaoxing\Article\Service\ArticleCategoryModel[] $articleCategories */
$articleCategories = wei()->articleCategoryModel();

/** @var Miaoxing\Article\Service\ArticleDetailModel $articleDetail */
$articleDetail = wei()->articleDetailModel;

/** @var Miaoxing\Article\Service\ArticleDetailModel|Miaoxing\Article\Service\ArticleDetailModel[] $articleDetails */
$articleDetails = wei()->articleDetailModel();

/** @var Miaoxing\Article\Service\ArticleLikeModel $articleLike */
$articleLike = wei()->articleLikeModel;

/** @var Miaoxing\Article\Service\ArticleLikeModel|Miaoxing\Article\Service\ArticleLikeModel[] $articleLikes */
$articleLikes = wei()->articleLikeModel();

/** @var Miaoxing\Article\Service\ArticleLogModel $articleLog */
$articleLog = wei()->articleLogModel;

/** @var Miaoxing\Article\Service\ArticleLogModel|Miaoxing\Article\Service\ArticleLogModel[] $articleLogs */
$articleLogs = wei()->articleLogModel();

/** @var Miaoxing\Article\Service\ArticleModel $article */
$article = wei()->articleModel;

/** @var Miaoxing\Article\Service\ArticleModel|Miaoxing\Article\Service\ArticleModel[] $articles */
$articles = wei()->articleModel();
