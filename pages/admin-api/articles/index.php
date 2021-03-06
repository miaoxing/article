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
            ->afterFind(function (ArticleModel $models, $req) {
                // @experimental 指定编号排序
                if ($req['sortField'] !== 'id') {
                    return;
                }

                $ids = (array) ($req['search']['id'] ?? []);
                if (!$ids) {
                    return;
                }

                $iterator = $models->getIterator();
                $iterator->uasort(function ($article1, $article2) use ($ids) {
                    $pos1 = array_search($article1->id, $ids);
                    $pos2 = array_search($article2->id, $ids);
                    return $pos1 - $pos2;
                });
                $models->fromArray($iterator);
            })
            ->exec($this);
    }
};
