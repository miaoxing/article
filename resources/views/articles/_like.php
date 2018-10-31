<?php

if (!wei()->article->enableLike) {
  return;
}
?>

<div class="article-like">
  <?= $article['likeNum'] ?>
  <i class="iconfont icon-aixin"></i>
</div>
