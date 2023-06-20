<?php

namespace MiaoxingTest\Article\Api\Articles;

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Test\BaseTestCase;

class IdTest extends BaseTestCase
{
    public function testGet()
    {
        $article = ArticleModel::save([
            'title' => '测试图文',
        ]);
        $article->detail()->saveRelation([
            'content' => '测试内容',
        ]);

        $ret = Tester::get('api/articles/' . $article->id);
        $this->assertRetSuc($ret);
        $this->assertSame('测试图文', $ret['data']['title']);
        $this->assertSame('测试内容', $ret['data']['detail']['content']);

        $article->destroy();
        $this->expectExceptionObject(new \Exception('Record not found', 404));
        Tester::get('api/articles/' . $article->id);
    }
}
