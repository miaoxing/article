<?php

$view->layout();
$wei->page->addAsset('plugins/article/css/articles.css');

$wei->event->trigger('beforeArticlesIndexRender');

require $app->getControllerFile('lists/' . $tpl);
require $view->getFile('@article/articles/_like-js.php');
