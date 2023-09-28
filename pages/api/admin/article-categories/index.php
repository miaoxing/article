<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BasePage;
use Miaoxing\Services\Page\CollGetTrait;
use Miaoxing\Services\Page\PostToPatchTrait;
use Miaoxing\Services\Service\IndexAction;

return new class () extends BasePage {
    use CollGetTrait;
    use PostToPatchTrait;

    public function get()
    {
        return IndexAction::new()
            ->beforeFind(function (ArticleCategoryModel $categories) {
                $categories->setDefaultSortColumn(['sort', 'id']);
            })
            ->afterReqQuery(function (ArticleCategoryModel $categories) {
                $categories->resetQueryParts(['limit', 'offset']);
            })
            ->afterFind(function (ArticleCategoryModel $categories) {
                $categories->toTree();
            })
            ->exec($this);
    }
};
