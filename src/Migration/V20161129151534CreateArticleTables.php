<?php

namespace Miaoxing\Article\Migration;

use Wei\Migration\BaseMigration;

class V20161129151534CreateArticleTables extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('articles')->tableComment('图文')
            ->bigId()
            ->int('app_id')
            ->bigInt('category_id')
            ->string('title')
            ->string('author', 8)->comment('作者')
            ->longText('content')
            ->string('slug')
            ->string('thumb')->comment('缩略图')
            ->bool('showCoverPic')->comment('封面图片显示在正文中')
            ->string('intro', 512)->comment('文章简介')
            ->int('pv')
            ->int('uv')
            ->int('likeNum')
            ->text('linkTo')->comment('linkTo服务配置数组')
            ->text('sourceLinkTo')->comment('原文链接的linkTo配置')
            ->int('sort')->defaults(50)
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();

        $this->schema->table('article_categories')->tableComment('图文栏目')
            ->bigId()
            ->int('app_id')
            ->bigInt('parent_id')
            ->smallInt('level', 1)->defaults(1)->comment('分类的层级')
            ->string('name')
            ->string('image')
            ->string('description')
            ->int('sort')
            ->string('list_tpl', 16)
            ->string('link_to', 2048)->comment('链接到的配置数组')
            ->bool('is_enabled')->defaults(1)->comment('是否启用')
            ->int('pv')
            ->int('uv')
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('articles')
            ->dropIfExists('article_categories');
    }
}
