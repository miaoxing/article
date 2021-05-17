<?php

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Page\CollGetTrait;
use Miaoxing\Services\Page\PostToPatchTrait;
use Miaoxing\Services\Service\IndexAction;

return new class extends BaseController {
    use CollGetTrait;
    use PostToPatchTrait;

    protected $expand = [
        'category',
    ];

    public function get()
    {
        return IndexAction
            ::beforeFind(function (ArticleModel $models) {
                $models->setDefaultSortColumn(['sort', 'id']);
            })
            ->exec($this);
    }
};
