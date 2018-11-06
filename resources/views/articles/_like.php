<?php

if (!wei()->article->enableLike) {
  return;
}

$like = wei()->articleLikeModel()->mine()->desc('id')->findOrInit(['article_id' => $article['id']]);
?>

<span class="js-article-like article-list-like article-like <?= $like['type'] ? 'text-danger' : 'link-dark' ?>"
  data-id="<?= $article['id'] ?>">
  <?= $article['likeNum'] ?>gi
  <i class="iconfont icon-aixin"></i>
</span>
