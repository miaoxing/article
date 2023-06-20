<?php

namespace MiaoxingTest\Article\Pages\Api\Admin\Articles;

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Article\Service\ArticleDetailModel;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Test\BaseTestCase;

/**
 * @mixin \ObjectReqMixin
 */
class IdTest extends BaseTestCase
{
    /**
     * @var ArticleCategoryModelry
     */
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category || $this->category = ArticleCategoryModel::save([
            'name' => '测试分类',
        ]);
    }

    public function testGet()
    {
        $article = ArticleModel::save([
            'title' => '测试图文',
        ]);

        $ret = Tester::getAdminApi('articles/' . $article->id);
        $this->assertRetSuc($ret);
        $this->assertSame('测试图文', $ret['data']['title']);

        $article->destroy();
        $this->expectExceptionObject(new \Exception('Record not found', 404));
        Tester::getAdminApi('articles/' . $article->id);
    }

    public function testGet404()
    {
        $this->expectExceptionObject(new \Exception('Record not found', 404));

        Tester::getAdminApi('articles/not-found');
    }

    public function testPatch()
    {
        $article = ArticleModel::save();

        $ret = Tester::setReq($this->objectReq)->patchAdminApi('articles/' . $article->id, [
            'categoryId' => $this->category->id,
            'title' => '测试',
            'detail' => [
                'content' => '内容',
            ],
        ]);

        /** @var ArticleModel $newArticle */
        $newArticle = $ret['data'];

        $this->assertSame($article->id, $newArticle->id);
        $this->assertNotEquals($article->title, $newArticle->title);
        $this->assertSame('测试', $newArticle->title);
        $this->assertSame('内容', $newArticle->detail->content);
    }

    public function testPostTitleTooLong()
    {
        $ret = Tester::setReq($this->objectReq)->postAdminApi('articles', [
            'categoryId' => $this->category->id,
            'title' => str_repeat('我', 256),
        ]);
        $this->assertRetErr($ret, '标题最多只能包含255个字符');
    }

    public function testPostWithoutTitle()
    {
        $ret = Tester::setReq($this->objectReq)->postAdminApi('articles', [
            'categoryId' => $this->category->id,
        ]);
        $this->assertRetErr($ret, '标题不能为空');
    }

    public function testPost()
    {
        $ret = Tester::setReq($this->objectReq)->postAdminApi('articles', [
            'categoryId' => $this->category->id,
            'title' => '测试',
        ]);
        $this->assertRetSuc($ret);
    }

    public function testInvalidCategoryId()
    {
        $ret = Tester::setReq($this->objectReq)->postAdminApi('articles', [
            'categoryId' => 0,
        ]);
        $this->assertRetErr($ret, '分类不存在');
    }

    public function testDelete()
    {
        $article = ArticleModel::save();
        /** @var ArticleDetailModel $detail */
        $detail = $article->detail()->saveRelation();

        $ret = Tester::deleteAdminApi('articles/' . $article->id);
        $this->assertRetSuc($ret);

        $article = ArticleModel::find($article->id);
        $this->assertNull($article);

        $detail = ArticleDetailModel::find($detail->id);
        $this->assertNull($detail);
    }
}
