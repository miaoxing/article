<?php

namespace MiaoxingTest\Article\Pages\Api\Admin\ArticleCategories;

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;

class IdTest extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        User::loginById(1);
    }

    public static function tearDownAfterClass(): void
    {
        User::logout();

        parent::tearDownAfterClass();
    }

    public function testGet()
    {
        $category = ArticleCategoryModel::save([
            'name' => '测试',
        ]);

        $ret = Tester::getAdminApi('article-categories/' . $category->id);
        $this->assertRetSuc($ret);
        $this->assertSame('测试', $ret['data']['name']);

        $category->destroy();
        $this->expectExceptionObject(new \Exception('Record not found', 404));
        Tester::getAdminApi('article-categories/' . $category->id);
    }

    public function testGet404()
    {
        $this->expectExceptionObject(new \Exception('Record not found', 404));

        Tester::getAdminApi('article-categories/not-found');
    }

    public function testPatch()
    {
        $category = ArticleCategoryModel::save();

        $ret = Tester::patchAdminApi('article-categories/' . $category->id, [
            'name' => '测试',
            'description' => '描述',
            'sort' => 60,
        ]);

        /** @var ArticleCategoryModel $newCategory */
        $newCategory = $ret['data'];

        $this->assertSame($category->id, $newCategory->id);
        $this->assertNotEquals($category->name, $newCategory->name);
        $this->assertSame('测试', $newCategory->name);
        $this->assertSame(60, $newCategory->sort);
        $this->assertSame('描述', $newCategory->description);
    }

    public function testPatchSelfAsParent()
    {
        $category = ArticleCategoryModel::save();

        $ret = Tester::patchAdminApi('article-categories/' . $category->id, [
            'parentId' => $category->id,
        ]);
        $this->assertRetErr($ret, '不能使用自己作为父级分类');
    }

    public function testPatchChangeSubCategoryToRootWillUpdateLevel()
    {
        $category = ArticleCategoryModel::save();
        $subCategory = ArticleCategoryModel::saveAttributes([
            'parentId' => $category->id,
            'level' => 2,
        ]);

        $ret = Tester::patchAdminApi('article-categories/' . $subCategory->id, [
            'parentId' => 0,
        ]);
        $this->assertRetSuc($ret);

        $subCategory->reload();
        $this->assertSame(1, $subCategory->level);
    }

    public function testPatchCantChangeRootCategoryToSubIfHasChildren()
    {
        $category = ArticleCategoryModel::save();
        $subCategory = ArticleCategoryModel::saveAttributes([
            'parentId' => $category->id,
            'level' => 2,
        ]);

        $ret = Tester::patchAdminApi('article-categories/' . $category->id, [
            'parentId' => $subCategory->id,
        ]);
        $this->assertRetErr($ret, '当前只支持 2 级分类，该分类已有子分类，不能成为其他分类的子分类');
    }

    public function testDelete()
    {
        $category = ArticleCategoryModel::save();

        $ret = Tester::deleteAdminApi('article-categories/' . $category->id);
        $this->assertRetSuc($ret);

        $category->reload();
        $this->assertTrue($category->isDeleted());
    }

    public function testDeleteWithChildren()
    {
        $category = ArticleCategoryModel::save();
        $subCategory = ArticleCategoryModel::save([
            'parentId' => $category->id,
        ]);

        $ret = Tester::deleteAdminApi('article-categories/' . $category->id);
        $this->assertRetSuc($ret);

        $subCategory->reload();
        $this->assertTrue($subCategory->isDeleted());
    }
}
