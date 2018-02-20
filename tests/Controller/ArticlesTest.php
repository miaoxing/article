<?php

namespace MiaoxingTest\Article\Controller;

use Miaoxing\Plugin\Test\BaseControllerTestCase;

class ArticlesTest extends BaseControllerTestCase
{
    public function testCreate()
    {
        wei()->setting->setValue('site.title', '测试站点');

        $category = wei()->category()->save([
            'parentId' => 'article',
            'type' => 'article',
            'name' => '测试分类名称',
        ]);

        $article = wei()->article()->save([
            'categoryId' => $category['id'],
            'title' => '测试图文标题',
            'author' => '作者',
            'thumb' => '缩略图',
            'intro' => '摘要',
            'content' => '内容',
            'sort' => 100,
        ]);

        $res = wei()->tester()
            ->controller('articles')
            ->action('show')
            ->request(['id' => $article['id']])
            ->response();

        $this->assertContains($article['title'], $res);
        $this->assertContains($category['name'], $res);
        $this->assertContains($article['content'], $res);
        $this->assertContains(substr($article['createTime'], 0, 10), $res);
        $this->assertContains(wei()->setting('site.title'), $res);
    }
}
