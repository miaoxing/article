<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Article\Metadata\ArticleLogTrait;
use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;

/**
 * 图文日志
 */
class ArticleLogModel extends BaseModel
{
    use ModelTrait;
    use ArticleLogTrait;
    use HasAppIdTrait;

    public const ACTION_VIEW = 1;
}
