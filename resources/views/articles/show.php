<?php

$view->layout();
$headImg = $wei->event->until('articlesShowGetHeadImg');
$wei->page->addCss('//at.alicdn.com/t/font_872953_843lwiv79j5.css');
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/article/css/articles.css') ?>">
<style>
  body {
    background: #fff;
  }
</style>
<?= $block->end() ?>

<div class="article-content">
  <h2 class="article-title"><?= $article['title'] ?></h2>

  <div class="article-description">
    <?php if ($headImg) : ?>
      <a class="article-description-item article-icon">
        <img src="<?= $headImg ?>">
      </a>
    <?php endif ?>

    <div class="article-description-item article-time">
      <?= date('Y-m-d', strtotime($article['updateTime'])) ?>
    </div>
    <div class="article-description-item article-category">
      <?= $article['author'] ?>
    </div>

    <?php if ($siteTitle = $wei->setting('site.title')) : ?>
      <div class="article-description-item">
        <?= $siteTitle ?>
      </div>
    <?php endif ?>
  </div>

  <div class="article-detail">
    <?php if ($article['showCoverPic']) : ?>
      <div class="article-thumb">
        <img src="<?= $article['thumb'] ?>">
      </div>
    <?php endif ?>
    <?= $article['content'] ?>
  </div>

  <?php if (wei()->article->enableLike) { ?>
    <a class="js-article-like article-like <?= $like['type'] ? 'text-danger' : 'link-dark' ?>"
      data-id="<?= $article['id'] ?>">
      <span class="js-article-num"><?= $article['likeNum'] ?></span>
      <i class="iconfont icon-aixin"></i>
    </a>
  <?php } ?>
</div>

<div class="hide">
  <img src="<?= $url('article-logs/create', ['article_id' => $article['id']]) ?>">
</div>

<?php $wei->event->trigger('afterArticlesShowRender', [$article]) ?>
<?php require $view->getFile('@article/articles/_like-js.php') ?>
