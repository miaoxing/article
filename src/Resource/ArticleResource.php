<?php

namespace Miaoxing\Article\Resource;

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\Resource\BaseResource;

class ArticleResource extends BaseResource
{
    public function transform(ArticleModel $article): array
    {
        return [
            $this->extract($article, [
                'id',
                'categoryId',
                'title',
                'author',
                'cover',
                'intro',
                'likeNum',
                'createdAt',
                'updatedAt',
                'sourceLink',
                'redirectLink',
            ]),
            'detail' => ArticleDetailResource::whenLoaded($article, 'detail'),
        ];
    }
}
