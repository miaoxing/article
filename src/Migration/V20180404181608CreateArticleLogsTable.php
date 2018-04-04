<?php

namespace Miaoxing\Article\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20180404181608CreateArticleLogsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('article_logs')
            ->id()
            ->int('app_id')
            ->int('article_id')
            ->int('user_id')
            ->tinyInt('action')
            ->timestamp('created_at')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('article_logs');
    }
}
