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

                $v = V::defaultOptional();
                $v->uBigInt('categoryId', '分类')->required($isNew)->modelExists(ArticleCategoryModel::class);
                $v->tinyChar('title', '标题')->required($isNew);
                $v->char('author', '作者', 0, 32);
                $v->imageUrl('cover', '封面');
                $v->char('intro', '摘要', 0, 512);
                $v->mediumText(['detail', 'content'], '正文');
                $v->object('sourceLink', '原文链接', 255);
                $v->object('redirectLink', '跳转地址', 255);
                $v->smallInt('sort', '顺序');
                return $v->check($req);
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
