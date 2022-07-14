<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Page\ItemTrait;
use Miaoxing\Services\Service\UpdateAction;
use Wei\V;

return new class () extends BaseController {
    use ItemTrait;

    public function patch($req)
    {
        return UpdateAction::new()
            ->beforeSave(function (ArticleCategoryModel $category, $req) {
                $isNew = $category->isNew();

                $v = V::defaultOptional();
                $v->uBigIntString('parentId', '父级分类')->required($isNew);
                $v->tinyChar('name', '名称')->required($isNew);
                $v->tinyChar('description', '简介');
                $v->smallInt('sort', '顺序');
                $ret = $v->check($req);
                if ($ret->isErr()) {
                    return $ret;
                }

                // 选择了父分类，但类型和父分类一致，同时层级为父分类加 1
                if ($category->parentId) {
                    if ($category->parentId === $category->id) {
                        return err('不能使用自己作为父级分类');
                    }

                    if ($category->children()->first()) {
                        return err('当前只支持 2 级分类，该分类已有子分类，不能成为其他分类的子分类');
                    }

                    $parent = $category->parent;
                    $category->level = $parent->level + 1;
                } else {
                    $category->level = 1;
                }
            })
            ->exec($this);
    }
};
