<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Article\Metadata\ArticleCategoryTrait;
use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Plugin\Model\SnowflakeTrait;
use Miaoxing\Plugin\Model\SoftDeleteTrait;

/**
 * @property ArticleCategoryModel $parent
 * @property ArticleCategoryModel[]|ArticleCategoryModel $children
 */
class ArticleCategoryModel extends BaseModel
{
    use ArticleCategoryTrait;
    use HasAppIdTrait;
    use ModelTrait;
    use ReqQueryTrait;
    use SnowflakeTrait;
    use SoftDeleteTrait;

    protected $columns = [
        'link' => [
            'cast' => 'json',
            'default' => [],
        ],
    ];

    public function getGuarded(): array
    {
        return array_merge($this->guarded, [
            'level',
        ]);
    }

    public function afterDestroy()
    {
        $this->children->destroy();
    }

    /**
     * 获取当前分类的父分类
     */
    public function parent(): self
    {
        return $this->belongsTo(static::class, 'id', 'parent_id');
    }

    public function children(): self
    {
        return $this->hasMany(static::class, 'parent_id')->desc('sort');
    }
}
