<?php

namespace MiaoxingTest\Article\Pages\AdminApi\Articles\Defaults;

use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Test\BaseTestCase;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        $ret = Tester::getAdminApi('articles/defaults');

        $this->assertRetSuc($ret);

        $data = $ret['data'];
        $this->assertArrayContains([
            'title' => '',
        ], $data->toArray());
    }
}
