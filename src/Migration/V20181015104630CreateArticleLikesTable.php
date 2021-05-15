<?php

namespace Miaoxing\Article\Migration;

use Wei\Migration\BaseMigration;

class V20181015104630CreateArticleLikesTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('article_likes')
            ->id()
            ->int('article_id')
            ->int('user_id')
            ->tinyInt('type')->defaults(1)
            ->timestamp('created_at')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('article_likes');
    }
}
