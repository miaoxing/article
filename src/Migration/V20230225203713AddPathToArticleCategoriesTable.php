<?php

namespace Miaoxing\Article\Migration;

use Miaoxing\Article\Service\ArticleCategoryModel;
use Wei\Migration\BaseMigration;

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
        ArticleCategoryModel::whereNotHas('parentId')->all()->updateTree();
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
