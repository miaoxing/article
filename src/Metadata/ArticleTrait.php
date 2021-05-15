<?php

namespace Miaoxing\Article\Metadata;

/**
 * @property int|null $id
 * @property int $appId
 * @property int $categoryId
 * @property string $title
 * @property string $author 作者
 * @property longtext $content
 * @property string $slug
 * @property string $thumb 缩略图
 * @property bool $showCoverPic 封面图片显示在正文中
 * @property string $intro 文章简介
 * @property int $pv
 * @property int $uv
 * @property int $likeNum
 * @property string $linkTo linkTo服务配置数组
 * @property string $sourceLinkTo 原文链接的linkTo配置
 * @property int $sort
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 * @property string|null $deletedAt
 * @property int $deletedBy
 * @internal will change in the future
 */
trait ArticleTrait
{
}
