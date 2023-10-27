<?php

namespace MiaoxingTest\Article\Pages\Api\Admin\ArticleCategories;

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        User::loginById(1);

        $category = ArticleCategoryModel::save([
            'name' => '测试',
            'sort' => 30,
            'description' => '测试描述',
        ]);
        $node = $category->saveNode([
            'name' => '子分类',
            'sort' => 60,
            'description' => '子分类描述',
        ]);

        $ret = Tester::request(['search' => ['id' => [$category->id, $node->id]]])->getAdminApi('article-categories');

        $categories = ArticleCategoryModel::findAll([$category->id])
            ->load('children')
            ->toArray();

        $this->assertSame($categories, $ret['data'], '返回列表数据包含下级');
    }

    public function testPost()
    {
        User::loginById(1);

        $ret = Tester::postAdminApi('article-categories', [
            'id' => '1', // ignored
            'level' => '2', // ignored
            'parentId' => 0,
            'name' => '测试' . mt_rand(),
            'sort' => '60',
            'description' => '描述',
        ]);
        $this->assertRetSuc($ret);

        /** @var ArticleCategoryModel $category */
        $category = $ret['data'];
        $this->assertNotEquals('1', $category->id);
        $this->assertStringStartsWith('测试', $category->name);
        $this->assertSame(60, $category->sort);
        $this->assertSame('描述', $category->description);
        $this->assertSame(1, $category->level);
    }

    public function testPostCreateSubCategory()
    {
        User::loginById(1);

        $category = ArticleCategoryModel::save();

        $ret = Tester::postAdminApi('article-categories', [
            'parentId' => $category->id,
            'name' => '测试' . mt_rand(),
        ]);
        $this->assertRetSuc($ret);

        /** @var ArticleCategoryModel $subCategory */
        $subCategory = $ret['data'];
        $this->assertSame($category->id, $subCategory->parentId);
        $this->assertSame(2, $subCategory->level);
    }
}
