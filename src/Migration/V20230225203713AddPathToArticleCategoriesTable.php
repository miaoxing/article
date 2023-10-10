<?php

namespace Miaoxing\Article\Migration;

use Miaoxing\Article\Service\ArticleCategoryModel;
use Wei\Migration\BaseMigration;
use Wei\QueryBuilder;

class V20230225203713AddPathToArticleCategoriesTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('article_categories')
            ->string('path')->comment('路径')->after('level')
            ->index('path')
            ->exec();

        // NOTE: 不使用 Model，兼容单元测试时没有 appId 导致错误
        $categories = QueryBuilder::table('article_categories')->where('parent_id', '')->select('id')->all();
        if ($categories) {
            ArticleCategoryModel::findAll(array_column($categories, 'id'))->updateTree();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('article_categories')
            ->dropColumn('path')
            ->dropIndex('path')
            ->exec();
    }
}
