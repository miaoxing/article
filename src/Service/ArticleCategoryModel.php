<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Plugin\Model\SnowflakeTrait;
use Wei\Model\SoftDeleteTrait;
use Wei\Model\TreeTrait;
use Wei\Ret;

/**
 * @property string|null $id 编号
 * @property string $appId 应用编号
 * @property string $parentId 父分类编号
 * @property int $level 层级
 * @property string $path 路径
 * @property string $name 名称
 * @property string $image 图片
 * @property string $description 简介
 * @property string $listTpl 列表模板
 * @property string $link 链接配置
 * @property bool $isEnabled 是否启用
 * @property int $pv 查看人数
 * @property int $uv 查看次数
 * @property int $sort 顺序，从大到小排列
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property string $createdBy
 * @property string $updatedBy
 * @property string|null $deletedAt
 * @property string $deletedBy
 * @property self|self[] $children
 */
class ArticleCategoryModel extends BaseModel
{
    use HasAppIdTrait;
    use ModelTrait;
    use ReqQueryTrait;
    use SnowflakeTrait;
    use SoftDeleteTrait;
    use TreeTrait;

    protected $parentIdColumn = 'parentId';

    protected $columns = [
        'link' => [
            'cast' => 'json',
            'default' => [],
        ],
    ];

    /**
     * @Relation
     * @return self|self[]
     */
    public function children(): self
    {
        return $this->hasMany(static::class, 'parent_id')->desc('sort');
    }

    public function checkParentId($parentId): Ret
    {
        if (!$parentId) {
            return suc();
        }

        if ((string) $parentId === $this->id) {
            return err('不能使用自己作为父级分类');
        }

        $parent = static::new()->findOrFail($parentId);
        if ($this->isAncestorOf($parent)) {
            return err('不能使用子分类作为父级分类');
        }

        return suc();
    }

    public function checkDestroy(): Ret
    {
        if (ArticleModel::findBy('categoryId', $this->id)) {
            return err(['很抱歉，该%s已被%s使用，不能删除', '分类', '图文']);
        }
        return suc();
    }
}
