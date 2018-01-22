<?php

$view->layout();
?>

<?php $isWechatCrop = wei()->plugin->isInstalled('wechat-corp'); ?>
<?php if ($isWechatCrop) : ?>
  <?php $account = wei()->wechatCorpAccount->getCurrentAccount(); ?>
<?php else : ?>
  <?php $account = wei()->wechatAccount->getCurrentAccount(); ?>
<?php endif; ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/article/css/articles.css') ?>">
<?= $block->end() ?>

<div class="article-content">
  <h2 class="article-title"><?= $article['title'] ?></h2>

  <div class="article-description">
    <?php if ($account) : ?>
      <a class="article-description-item article-icon" href="javascript:;">
        <img src="<?= $account['headImg']; ?>">
      </a>
    <?php endif; ?>

    <div class="article-description-item article-time">
      <?= date('Y-m-d', strtotime($article['updateTime'])) ?>
    </div>
    <div class="article-description-item article-category">
      <?= $article['author'] ?>
    </div>

    <?php if ($account) : ?>
      <div class="article-description-item">
        <?= $account['nickName'] ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="article-detail">
    <?php if ($article['showCoverPic']) : ?>
      <div class="article-thumb">
        <img src="<?= $article['thumb']; ?>">
      </div>
    <?php endif; ?>
    <?= $article['content'] ?>
  </div>
</div>

<?php $wei->event->trigger('afterArticlesShowRender', [$article]) ?>
