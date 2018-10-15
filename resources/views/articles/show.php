<?php

$view->layout();
$headImg = $wei->event->until('articlesShowGetHeadImg');
$wei->page->addCss('//at.alicdn.com/t/font_872953_843lwiv79j5.css');
?>

<?= $block->css() ?>
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

  <?php if (wei()->article->enableLike) { ?>
    <a class="js-article-like article-like <?= $like['type'] ? 'text-danger' : 'link-dark' ?>">
      <i class="iconfont icon-aixin"></i>
      <span class="js-article-num"><?= $article['likeNum'] ?></span>
    </a>
  <?php } ?>
</div>

<div class="hide">
  <img src="<?= $url('article-logs/create', ['article_id' => $article['id']]) ?>">
</div>

<?php $wei->event->trigger('afterArticlesShowRender', [$article]) ?>

<?= $block->js() ?>
<script>
  $('.js-article-like').click(function() {
    var $that = $(this);
    var $num = $('.js-article-num');
    var num = parseInt($num.html(), 10);
     $.ajax({
       url: $.url('article-likes/toggle', {articleId: <?= $article['id'] ?>}),
       dataType: 'json',
     }).then(function (ret) {
       if (ret.code !== 1) {
         $.msg(ret);
         return;
       }

       if ($that.hasClass('link-dark')) {
         $that.removeClass('link-dark').addClass('text-danger');
         $num.html(num + 1);
       } else {
         $that.removeClass('text-danger').addClass('link-dark');
         $num.html(num - 1);
       }
     });
  });
</script>
<?= $block->end() ?>
