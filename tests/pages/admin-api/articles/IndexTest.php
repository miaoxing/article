<?php

namespace MiaoxingTest\Article\Pages\AdminApi\Articles;

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        User::loginById(1);

        $article = ArticleModel::save([
            'title' => '测试标题' . time(),
        ]);

        $ret = Tester::getAdminApi('articles');

        $this->assertSame($article->title, $ret['data'][0]['title']);
    }
}
