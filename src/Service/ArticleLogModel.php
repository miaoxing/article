<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Article\Metadata\ArticleLogTrait;
use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Plugin\Model\HasAppIdTrait;

/**
 * 图文日志
 */
class ArticleLogModel extends BaseModelV2
{
    use ArticleLogTrait;
    use HasAppIdTrait;

    const ACTION_VIEW = 1;
}
