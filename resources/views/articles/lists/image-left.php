<ul class="list article-list">
  <?php foreach ($articles as $article) : ?>
    <li>
      <a class="list-item" href="<?= $article->getUrl() ?>">
        <div class="list-col article-image-left">
          <img src="<?= $article['thumb'] ?>">
        </div>
        <div class="list-col list-middle">
          <h4 class="list-heading">
            <?= $article['title'] ?>
          </h4>

          <div class="list-body">
            <?= $article['intro'] ?>

            <div class="article-like">
              <i class="iconfont icon-aixin"></i> <?= $article['likeNum'] ?>
            </div>
          </div>
        </div>
      </a>
    </li>
  <?php endforeach ?>
</ul>
