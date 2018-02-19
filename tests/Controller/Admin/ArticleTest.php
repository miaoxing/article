<?php

namespace MiaoxingTest\Article\Controller\Admin;

use Miaoxing\Plugin\Test\BaseControllerTestCase;

class ArticleTest extends BaseControllerTestCase
{
    public function testCreate()
    {
        $category = wei()->category()->save([
            'parentId' => 'article',
            'type' => 'article',
            'name' => '测试分类名称',
        ]);

        $ret = wei()->tester()
            ->login(1)
            ->controller('admin/article')
            ->action('create')
            ->request([
                'categoryId' => $category['id'],
                'title' => '测试图文标题',
                'author' => '作者',
                'thumb' => '缩略图',
                'intro' => '摘要',
                'content' => '内容',
                'sort' => 100,
            ])
            ->json()
            ->response();
        $this->assertRetSuc($ret);

        $ret = wei()->tester()
            ->login(1)
            ->controller('admin/article')
            ->json()
            ->response();
        $this->assertRetSuc($ret);

        $this->assertArraySubset([
            'categoryId' => $category['id'],
            'title' => '测试图文标题',
            'author' => '作者',
            'thumb' => '缩略图',
            'intro' => '摘要',
            'content' => '内容',
            'sort' => 100,
            'category' => [
                'name' => '测试分类名称',
            ],
        ], $ret['data'][0]);
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
