<?php

namespace Miaoxing\Article\Service;

use Miaoxing\Config\ConfigTrait;
use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\ModelTrait;

/**
 * @property \Miaoxing\LinkTo\Service\LinkTo $linkTo
 * @method string linkTo(array $options)
 * @property \Wei\Url $url
 * @method string url($url = '', $params = array())
 * @property \Wei\Logger $logger
 * @property bool $enableLike
 */
class ArticleModel extends BaseModel
{
    use ModelTrait;

    protected $configs = [
        'enableLike' => [
            'default' => false,
        ],
    ];

    protected $exts = [
        'jpg',
        'jpeg',
        'gif',
        'png',
        'bmp',
    ];

    protected $autoId = true;

    protected $data = [
        'sort' => 50,
        'linkTo' => [],
        'sourceLinkTo' => [],
        'content' => '',
    ];

    protected $category;

    public function afterFind()
    {
        parent::afterFind();
        $this['linkTo'] = $this->linkTo->decode($this['linkTo']);
        $this['sourceLinkTo'] = $this->linkTo->decode($this['sourceLinkTo']);

        $this->event->trigger('postImageDataLoad', [&$this, ['thumb', 'content']]);
    }

    public function beforeSave()
    {
        parent::beforeSave();
        $this['linkTo'] = $this->linkTo->encode($this['linkTo']);
        $this['sourceLinkTo'] = $this->linkTo->encode($this['sourceLinkTo']);

        $this->event->trigger('preImageDataSave', [&$this, ['thumb', 'content']]);
    }

    public function getCategory()
    {
        $this->category || $this->category = wei()->category()->findOrInitById($this['categoryId']);

        return $this->category;
    }

    /**
     * 是否使用了外部链接
     * @return bool
     */
    public function isLinkTo()
    {
        return $this['linkTo'] && $this['linkTo']['type'];
    }

    /**
     * 是否保密
     * @return bool
     */
    public function isSafe()
    {
        return $this['safe'];
    }

    /**
     * 生成访问文章,如果设置了外部链接,使用外部链接地址
     *
     * @return string
     */
    public function getUrl()
    {
        if ($this->isLinkTo()) {
            return $this->linkTo->getUrl($this['linkTo']);
        } else {
            return $this->url('articles/%s', $this['id']);
        }
    }

    /**
     * 生成带微信登录的URL地址
     *
     * @return string
     */
    public function getFullUrl()
    {
        if ($this->isLinkTo()) {
            return $this->linkTo->getFullUrl($this['linkTo']);
        } else {
            return $this->request->getUrlFor($this->url('article/show', ['id' => $this['id']]));
        }
    }

    /**
     * 获取原文链接
     * @return bool|string
     */
    public function getSourceUrl()
    {
        if ($this['sourceLinkTo'] && $this['sourceLinkTo']['type']) {
            return $this->linkTo->getFullUrl($this['sourceLinkTo']);
        }

        return false;
    }

    /**
     * 使用回调方法更新图片地址,可用于上传图片到CDN,微信等
     *
     * @param callable $fn
     * @return array
     */
    public function replaceImages(callable $fn)
    {
        try {
            $rxp = "/<img.+?src=[\"'](.+?)[\"'].*?>/i";
            $this['content'] = preg_replace_callback($rxp, function ($matches) use ($fn) {
                return $this->execReplaceCallback($matches, $fn);
            }, $this['content']);
        } catch (\Exception $e) {
            return ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return ['code' => 1, 'message' => '替换完成'];
    }

    /**
     * 执行替换和回调方法
     *
     * @param array $matches
     * @param callable $fn
     * @return mixed
     */
    protected function execReplaceCallback(array $matches, callable $fn)
    {
        list($ori, $url) = $matches;
        $url = trim($url);

        if (!$url) {
            $this->logger->info('Ignore empty url', ['url' => $ori]);

            return $ori;
        }

        // 检查是否为图片
        $ext = $this->getExt($url);
        if (!in_array($ext, $this->exts)) {
            $this->logger->info('Ignore invalid image extension', ['url' => $url]);

            return $ori;
        }

        // 通过外部方法更新URL地址
        $newUrl = $fn($url);
        if (!$newUrl) {
            return $ori;
        }

        // 组装成新地址
        $this->logger->info('Replace content image', [
            'from' => $url,
            'to' => $newUrl,
        ]);

        return str_replace($url, $newUrl, $ori);
    }

    /**
     * 根据编号顺序查找图文
     *
     * @param array $ids
     * @return ArticleModel|ArticleModel[]
     */
    public function findByIds(array $ids)
    {
        $ids = array_map('intval', $ids);
        if ($ids) {
            $this->orderBy('FIELD(id, ' . implode(', ', $ids) . ')')->findAll(['id' => $ids]);
        } else {
            $this->beColl();
        }

        return $this;
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->clearTagCache();
    }

    public function afterDestroy()
    {
        parent::afterDestroy();
        $this->clearTagCache();
    }

    /**
     * 获取文件扩展名
     *
     * @param string $file
     * @return string
     */
    protected function getExt($file)
    {
        $file = basename($file);
        // Use substr instead of pathinfo, because pathinfo may return error value in unicode
        if (false !== $pos = strrpos($file, '.')) {
            return strtolower(substr($file, $pos + 1));
        } else {
            return '';
        }
    }

    public function getTypeName()
    {
        return $this->isLinkTo() ? '跳转' : '图文';
    }
}
