<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BasePage;

return new class extends BasePage {
    public function get($req)
    {
        $category = ArticleCategoryModel::findOrFail($req['id']);

        return $category->toRet();
    }
};
