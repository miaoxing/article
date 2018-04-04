<?php

namespace Miaoxing\Article\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20161129151534CreateArticleTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('article')
            ->id()
            ->string('categoryId', 36)
            ->string('title')
            ->string('author', 8)->comment('作者')
            ->longText('content')
            ->string('slug')
            ->string('thumb')->comment('缩略图')
            ->bool('showCoverPic')->comment('封面图片显示在正文中')
            ->string('intro', 512)->comment('文章简介')
            ->int('pv')
            ->int('uv')
            ->text('linkTo')->comment('linkTo服务配置数组')
            ->text('sourceLinkTo')->comment('原文链接的linkTo配置')
            ->int('sort')->defaults(50)
            ->timestampsV1()
            ->userstampsV1()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('article');
    }
}
