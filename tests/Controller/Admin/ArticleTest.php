<?php

namespace MiaoxingTest\Article\Controller\Admin;

use Miaoxing\Plugin\Test\BaseControllerTestCase;

class ArticleTest extends BaseControllerTestCase
{
    public function testCreate()
    {
        $category = wei()->category();
    }

    public function testDestroy()
    {
        $article = wei()->article()->save();
        $ret = wei()->tester()
            ->login(1)
            ->controller('admin/article')
            ->action('show')
            ->request(['id' => $article['id']])
            ->json()
            ->response();
        $this->assertRetSuc($ret);

        $article->destroy();
        $this->setExpectedException(\Exception::class, 'Record not found', 404);
        wei()->tester()
            ->login(1)
            ->controller('admin/article')
            ->action('show')
            ->request(['id' => $article['id']])
            ->response();
    }
}
