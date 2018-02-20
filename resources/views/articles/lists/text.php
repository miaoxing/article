<ul class="list list-link">
  <?php foreach ($articles as $article) : ?>
    <li>
      <a href="<?= $article->getUrl() ?>" class="list-item has-feedback">
        <h4 class="list-heading">
          <?= $article['title'] ?>
        </h4>
        <i class="bm-angle-right list-feedback"></i>
      </a>
    </li>
  <?php endforeach ?>
</ul>
