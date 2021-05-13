<?php

namespace MiaoxingTest\Category\Pages\AdminApi\Categories;

use Miaoxing\Category\Service\CategoryModel;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;

class IndexTest extends BaseTestCase
{
    public function testPost()
    {
        User::loginById(1);

        $ret = Tester::postAdminApi('categories', [
            'id' => '1', // ignored
            'level' => '2', // ignored
            'name' => '测试',
            'sort' => '60',
            'description' => '描述',
        ]);
        $this->assertRetSuc($ret);

        /** @var CategoryModel $category */
        $category = $ret['data'];
        $this->assertNotEquals('1', $category->id);
        $this->assertSame('测试', $category->name);
        $this->assertSame(60, $category->sort);
        $this->assertSame('描述', $category->description);
        $this->assertSame(1, $category->level);
    }

    public function testPostCreateSubCategory()
    {
        User::loginById(1);

        $category = CategoryModel::save();

        $ret = Tester::postAdminApi('categories', [
            'parentId' => $category->id,
        ]);
        $this->assertRetSuc($ret);

        /** @var CategoryModel $subCategory */
        $subCategory = $ret['data'];
        $this->assertSame($category->id, $subCategory->parentId);
        $this->assertSame(2, $subCategory->level);
    }
}
