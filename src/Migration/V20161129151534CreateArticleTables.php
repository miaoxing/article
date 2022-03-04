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
            ->bigId()->comment('编号')
            ->uBigInt('app_id')->comment('应用编号')
            ->bigInt('category_id')->comment('分类编号')
            ->string('title')->comment('标题')
            ->string('author', 32)->comment('作者')
            ->string('slug')->comment('URL 路径')
            ->string('cover')->comment('封面')
            ->string('intro', 512)->comment('摘要')
            ->int('pv')->comment('查看人数')
            ->int('uv')->comment('查看次数')
            ->int('like_num')->comment('点赞数量')
            ->string('source_link')->comment('原文链接')
            ->string('redirect_link')->comment('跳转链接')
            ->smallInt('sort')->defaults(50)->comment('顺序，从大到小排列')
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();

        $this->schema->table('article_details')->tableComment('图文详情；1:1')
            ->bigId()->comment('编号')
            ->uBigInt('app_id')->comment('应用编号')
            ->bigInt('article_id')->comment('图文编号')
            ->bool('show_cover')->comment('封面是否显示在正文中')
            ->mediumText('content')->comment('正文')
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();

        $this->schema->table('article_categories')->tableComment('图文分类；1:1')
            ->bigId()->comment('编号')
            ->uBigInt('app_id')->comment('应用编号')
            ->bigInt('parent_id')->comment('父分类编号')
            ->smallInt('level', 1)->defaults(1)->comment('层级')
            ->string('name')->comment('名称')
            ->string('image')->comment('图片')
            ->string('description')->comment('简介')
            ->string('list_tpl', 16)->comment('列表模板')
            ->string('link', 2048)->comment('链接配置')
            ->bool('is_enabled')->defaults(1)->comment('是否启用')
            ->int('pv')->comment('查看人数')
            ->int('uv')->comment('查看次数')
            ->smallInt('sort')->defaults(50)->comment('顺序，从大到小排列')
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
            ->dropIfExists('article_details')
            ->dropIfExists('article_categories');
    }
}
