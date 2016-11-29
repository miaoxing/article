<?php

namespace Miaoxing\Article\Controller\Admin;

class Article extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '图文管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
        'audit' => '审核',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $articles = wei()->article();

                // 分页
                $articles->limit($req['rows'])->page($req['page']);

                // 排序
                $articles->desc('sort')->desc('id');

                // 搜索
                if ($req['search']) {
                    $articles->andWhere('title LIKE ?', '%' . $req['search'] . '%');
                }

                // 分类筛选
                if ($req['categoryId']) {
                    $articles->andWhere('categoryId = ?', $req['categoryId']);
                }

                wei()->event->trigger('beforeArticleFind', [$articles, $req]);

                $data = [];
                foreach ($articles as $article) {
                    $data[] = $article->toArray() + [
                            'category' => $article->getCategory()->toArray(),
                        ];
                }

                wei()->event->trigger('afterArticleFind', [$articles, $req, $data]);

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $articles->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function editAction($req)
    {
        $article = wei()->article()->findId($req['id']);

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $article = wei()->article()->findId($req['id'])->fromArray($req);

        //$article['content'] = wei()->cdn->uploadImagesFromHtml($article['content']);

        $article->save();

        return $this->suc();
    }

    public function destroyAction($req)
    {
        wei()->article()->findOneById($req['id'])->destroy();

        return $this->suc();
    }

    public function showAction($req)
    {
        return $this->suc([
            'data' => wei()->article()->findOneById($req['id'])->toArray(),
        ]);
    }

    public function auditAction($req)
    {
        $article = wei()->article()->findOneById($req['id']);
        $ret = wei()->audit->audit($article, $req['pass'], $req['description']);

        return $this->ret($ret);
    }
}
