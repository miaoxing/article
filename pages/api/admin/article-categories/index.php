<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BasePage;
use Miaoxing\Services\Page\CollGetTrait;
use Miaoxing\Services\Page\PostToPatchTrait;
use Miaoxing\Services\Service\IndexAction;

return new class () extends BasePage {
    use CollGetTrait;
    use PostToPatchTrait;

    protected $include = [
        'children',
    ];

    public function get()
    {
        return IndexAction::new()
            ->beforeFind(function (ArticleCategoryModel $models) {
                $models->where('level', 1)
                    ->setDefaultSortColumn(['sort', 'id']);
            })
            ->exec($this);
    }
};
