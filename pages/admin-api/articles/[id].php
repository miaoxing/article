<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Article\Service\ArticleDetailModel;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Service\DestroyAction;
use Miaoxing\Services\Service\ShowAction;
use Miaoxing\Services\Service\UpdateAction;
use Wei\V;

return new /**
 * @mixin \ObjectReqMixin
 */
class () extends BaseController {
    protected $include = [
        'detail',
    ];

    public function get()
    {
        return ShowAction::exec($this);
    }

    public function patch()
    {
        return UpdateAction
            ::setReq($this->objectReq)
            ->beforeSave(function (ArticleModel $article, $req) {
                $isNew = $article->isNew();
                return V::defaultOptional()
                    ->uBigInt('categoryId', '分类')->required($isNew)->modelExists(ArticleCategoryModel::class)
                    ->tinyChar('title', '标题')->required($isNew)
                    ->char('author', '作者', 0, 32)
                    ->tinyChar('cover', '封面')
                    ->char('intro', '摘要', 0, 512)
                    ->mediumText(['detail', 'content'], '正文')
                    ->object('sourceLink', '原文链接')
                    ->object('redirectLink', '跳转地址')
                    ->smallInt('sort', '顺序')
                    ->check($req);
            })
            ->afterSave(function (ArticleModel $article, $req) {
                if (isset($req['detail'])) {
                    $article->detail()->saveRelation((array) $req['detail']);
                }
            })
            ->exec($this);
    }

    public function delete()
    {
        return DestroyAction
            ::afterDestroy(function (ArticleModel $article) {
                ArticleDetailModel::findBy('articleId', $article->id)->destroy();
            })
            ->exec($this);
    }
};
