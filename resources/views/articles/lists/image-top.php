<ul class="list article-list">
  <?php foreach ($articles as $article) : ?>
    <li>
      <a class="list-item flex-column" href="<?= $article->getUrl() ?>">
        <img class="img-fluid mb-2" src="<?= wei()->asset->thumb($article['thumb'], 750) ?>">
        <h4 class="list-item-title">
          <?= $article['title'] ?>
        </h4>
        <div class="list-item-text">
          <?= $article['intro'] ?>
          <?php require $view->getFile('@article/articles/_like.php') ?>
        </div>
      </a>
    </li>
  <?php endforeach ?>
  <?php require $app->getControllerFile('lists/_empty') ?>
</ul>
