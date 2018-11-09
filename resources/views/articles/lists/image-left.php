<ul class="list article-list">
  <?php foreach ($articles as $article) : ?>
    <li>
      <a class="list-item" href="<?= $article->getUrl() ?>">
        <div class="list-col article-image-left">
          <img src="<?= wei()->asset->thumb($article['thumb'], 216) ?>">
        </div>
        <div class="list-col list-middle">
          <h4 class="list-heading">
            <?= $article['title'] ?>
          </h4>

          <div class="list-body">
            <?= $article['intro'] ?>
            <?php require $view->getFile('@article/articles/_like.php') ?>
          </div>
        </div>
      </a>
    </li>
  <?php endforeach ?>
</ul>
