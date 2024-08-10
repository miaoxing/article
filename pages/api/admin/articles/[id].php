<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Article\Service\ArticleDetailModel;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BasePage;
use Miaoxing\Services\Service\DestroyAction;
use Miaoxing\Services\Service\ShowAction;
use Miaoxing\Services\Service\UpdateAction;
use Wei\V;

return new /**
 * @mixin \ObjectReqMixin
 */
class extends BasePage {
    protected $include = [
        'detail',
    ];

    public function get()
    {
        return ShowAction::exec($this);
    }

    public function patch()
    {
        return UpdateAction::setReq($this->objectReq)
            ->beforeSave(static function (ArticleModel $article, $req) {
                $isNew = $article->isNew();

                $v = V::defaultOptional();
                $v->setModel($article);
                $v->modelExists('categoryId', '分类', ArticleCategoryModel::class)->allowEmpty();
                $v->modelColumn('title', '标题')->required($isNew);
                $v->modelColumn('author', '作者');
                $v->imageUrl('cover', '封面')->allowEmpty();
                $v->modelColumn('intro', '摘要');
                $v->mediumText(['detail', 'content'], '正文');
                $v->object('sourceLink', '原文链接', 255);
                $v->object('redirectLink', '跳转地址', 255);
                $v->modelColumn('sort', '顺序');
                return $v->check($req);
            })
            ->afterSave(static function (ArticleModel $article, $req) {
                if (isset($req['detail'])) {
                    $article->detail()->saveRelation((array) $req['detail']);
                }
            })
            ->exec($this);
    }

    public function delete()
    {
        return DestroyAction::new()
            ->afterDestroy(static function (ArticleModel $article) {
                ArticleDetailModel::findBy('articleId', $article->id)->destroy();
            })
            ->exec($this);
    }
};
