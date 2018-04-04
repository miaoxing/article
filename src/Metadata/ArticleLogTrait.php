<?php

namespace Miaoxing\Article\Metadata;

/**
 * ArticleLogTrait
 *
 * @property int $id
 * @property int $articleId
 * @property int $userId
 * @property int $action
 * @property string $createdAt
 */
trait ArticleLogTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'article_id' => 'int',
        'user_id' => 'int',
        'action' => 'int',
        'created_at' => 'datetime',
    ];
}
