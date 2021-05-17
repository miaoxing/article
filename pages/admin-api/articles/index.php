<?php

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Page\PostToPatchTrait;
use Miaoxing\Services\Service\IndexAction;

return new class extends BaseController {
    use PostToPatchTrait;

    public function get()
    {
        return IndexAction
            ::beforeFind(function (ArticleModel $models) {
                $models->setDefaultSortColumn(['sort', 'id']);
            })
            ->afterFind(function (ArticleModel $models) {
                $models->load('category');
            })
            ->exec($this);
    }
};
