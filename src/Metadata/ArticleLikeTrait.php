<?php

namespace Miaoxing\Article\Metadata;

/**
 * ArticleLikeTrait
 *
 * @property int $id
 * @property int $articleId
 * @property int $userId
 * @property int $type
 * @property string $createdAt
 */
trait ArticleLikeTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'article_id' => 'int',
        'user_id' => 'int',
        'type' => 'int',
        'created_at' => 'datetime',
    ];
}
