<?php $view->layout('plugin:layouts/jqm.php') ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('assets/article/article.css') ?>">
<?= $block->end() ?>

<div data-role="content">
  <ul data-role="listview" class="article-list">
    <?php foreach ($articles as $article) : ?>
      <li><a data-ajax="false" href="<?= $article->getUrl() ?>"><?= $article['title'] ?></a></li>
    <?php endforeach ?>
  </ul>
</div>
