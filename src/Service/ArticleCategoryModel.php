<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Article\Metadata\ArticleCategoryTrait;
use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Plugin\Model\SnowflakeTrait;
use Wei\Model\SoftDeleteTrait;
use Wei\Model\TreeTrait;
use Wei\Ret;

class ArticleCategoryModel extends BaseModel
{
    use ArticleCategoryTrait;
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
