<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Page\PostToPatchTrait;
use Miaoxing\Services\Service\IndexAction;

return new class extends BaseController {
    use PostToPatchTrait;

    public function get()
    {
        return IndexAction
            ::beforeFind(function (ArticleCategoryModel $models) {
                $models->where('level', 1)
                    ->setDefaultSortColumn(['sort', 'id']);
            })
            ->afterFind(function (ArticleCategoryModel $models) {
                $models->load('children');
            })
            ->exec($this);
    }
};
