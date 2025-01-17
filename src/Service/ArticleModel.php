<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Plugin\Model\SnowflakeTrait;
use Wei\Model\SoftDeleteTrait;

/**
 * @property string|null $id 编号
 * @property string $appId 应用编号
 * @property string $categoryId 分类编号
 * @property string $title 标题
 * @property string $author 作者
 * @property string $slug URL 路径
 * @property string $cover 封面
 * @property string $intro 摘要
 * @property int $pv 查看人数
 * @property int $uv 查看次数
 * @property int $likeNum 点赞数量
 * @property object $sourceLink 原文链接
 * @property object $redirectLink 跳转链接
 * @property int $sort 顺序，从大到小排列
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property string $createdBy
 * @property string $updatedBy
 * @property string|null $deletedAt
 * @property string $deletedBy
 * @property ArticleDetailModel $detail
 * @property ArticleCategoryModel $category
 */
class ArticleModel extends BaseModel
{
    use HasAppIdTrait;
    use ModelTrait;
    use ReqQueryTrait;
    use SnowflakeTrait;
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
