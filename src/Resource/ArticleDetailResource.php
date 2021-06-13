<?php

namespace Miaoxing\Article\Resource;

use Miaoxing\Article\Service\ArticleDetailModel;
use Miaoxing\Plugin\Resource\BaseResource;

class ArticleDetailResource extends BaseResource
{
    public function transform(ArticleDetailModel $detail): array
    {
        return $detail->toArray([
            'showCover',
            'content',
        ]);
    }
}
