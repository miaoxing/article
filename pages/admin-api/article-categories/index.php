<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Page\CollGetTrait;
use Miaoxing\Services\Page\PostToPatchTrait;
use Miaoxing\Services\Service\IndexAction;

return new class extends BaseController {
    use CollGetTrait;
    use PostToPatchTrait;

    protected $expand = [
        'children',
    ];

    public function get()
    {
        return IndexAction
            ::beforeFind(function (ArticleCategoryModel $models) {
                $models->where('level', 1)
                    ->setDefaultSortColumn(['sort', 'id']);
            })
            ->exec($this);
    }
};
