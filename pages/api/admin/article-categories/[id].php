<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BasePage;
use Miaoxing\Services\Page\ItemTrait;
use Miaoxing\Services\Service\UpdateAction;
use Wei\V;

return new class () extends BasePage {
    use ItemTrait;

    public function patch($req)
    {
        return UpdateAction::new()
            ->validate(static function (ArticleCategoryModel $category, $req) {
                $v = V::defaultOptional();
                $v->setModel($category);

                $parentIdV = $v->modelColumn('parentId', '父级分类');
                $parentIdV->callback(static function ($parentId) use ($category) {
                    $ret = $category->checkParentId($parentId);
                    return $ret->isErr() ? $ret->getMessage() : true;
                });

                $v->modelColumn('name', '名称')->requiredIfNew()->notEmpty()->notModelDup();
                $v->modelColumn('description', '简介');
                $v->modelColumn('sort', '顺序');
                return $v->check($req);
            })
            ->exec($this);
    }
};
