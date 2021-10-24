<?php

use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Plugin\BaseController;

return new class () extends BaseController {
    public function get()
    {
        return ArticleCategoryModel::toRet();
    }
};
