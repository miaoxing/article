<?php

$view->layout();
$headImg = $wei->event->until('articlesShowGetHeadImg');
?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/article/css/articles.css') ?>">
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
</div>

<?php $wei->event->trigger('afterArticlesShowRender', [$article]) ?>
