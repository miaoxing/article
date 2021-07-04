<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Article\Metadata\ArticleTrait;
use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Plugin\Model\SoftDeleteTrait;

/**
 * @property ArticleDetailModel $detail
 */
class ArticleModel extends BaseModel
{
    use ArticleTrait;
    use HasAppIdTrait;
    use ModelTrait;
    use ReqQueryTrait;
    use SoftDeleteTrait;

    protected $columns = [
        'sourceLink' => [
            'cast' => 'object',
            'default' => [],
        ],
        'redirectLink' => [
            'cast' => 'object',
            'default' => [],
        ],
    ];

    public function detail(): ArticleDetailModel
    {
        return $this->hasOne(ArticleDetailModel::class);
    }

    public function category(): ArticleCategoryModel
    {
        return $this->belongsTo(ArticleCategoryModel::class, 'id', 'category_id');
    }
}
