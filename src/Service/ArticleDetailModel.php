<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Article\Metadata\ArticleDetailTrait;
use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\SnowflakeTrait;
use Miaoxing\Plugin\Model\SoftDeleteTrait;

class ArticleDetailModel extends BaseModel
{
    use ArticleDetailTrait;
    use HasAppIdTrait;
    use ModelTrait;
    use SnowflakeTrait;
    use SoftDeleteTrait;
}
