<?php

use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\BaseController;

return new class () extends BaseController {
    public function get()
    {
        return ArticleModel::toRet();
    }
};
