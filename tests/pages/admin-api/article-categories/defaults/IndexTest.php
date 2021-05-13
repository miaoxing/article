<?php

namespace MiaoxingTest\Article\Pages\AdminApi\ArticleCategories\Defaults;

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Test\BaseTestCase;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        $ret = Tester::getAdminApi('article-categories/defaults');
        $this->assertRetSuc($ret);
        $this->assertInstanceOf(ArticleCategoryModel::class, $ret['data']);
    }
}
