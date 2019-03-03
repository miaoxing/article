<ul class="list">
  <?php foreach ($articles as $article) : ?>
    <li>
      <a href="<?= $article->getUrl() ?>" class="list-item list-has-feedback">
        <h4 class="list-title">
          <?= $article['title'] ?>
        </h4>
        <i class="bm-angle-right list-feedback"></i>
      </a>
    </li>
  <?php endforeach ?>
  <?php require $app->getControllerFile('lists/_empty') ?>
</ul>
