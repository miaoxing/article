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
        $this->scheme->table('article')
            ->id()
            ->string('categoryId', 36)
            ->string('title')
            ->string('author', 8)
            ->exec();
/*CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '缩略图',
  `showCoverPic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '封面图片显示在正文中',
  `intro` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '文章简介',
  `views` int(11) NOT NULL,
  `linkTo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'linkTo服务配置数组',
  `sourceLinkTo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '原文链接的linkTo配置',
  `sort` int(11) NOT NULL DEFAULT '50',
  `createUser` int(11) NOT NULL,
  `createTime` datetime NOT NULL,
  `updateUser` int(11) NOT NULL,
  `updateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1025520233 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;*/
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        //
    }
}
