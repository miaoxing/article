<ul class="list article-list">
  <?php foreach ($articles as $article) : ?>
    <li>
      <a class="list-item" href="<?= $article->getUrl() ?>">
        <div class="list-row article-image-top">
          <img src="<?= $article['thumb'] ?>">
        </div>
        <div class="list-row">
          <h4 class="list-heading">
            <?= $article['title'] ?>
          </h4>
          <div class="list-body">
            <?= $article['intro'] ?>
            <?= $view->render('@article/articles/_like.php') ?>
          </div>
        </div>
      </a>
    </li>
  <?php endforeach ?>
</ul>
