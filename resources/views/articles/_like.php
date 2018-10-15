<?php

if (!wei()->article->enableLike) {
  return;
}
?>

<div class="article-like">
  <i class="iconfont icon-aixin"></i> <?= $article['likeNum'] ?>
</div>
