<?php

$view->layout();
$wei->page->addAsset('plugins/article/css/articles.css')
  ->addCss('//at.alicdn.com/t/font_872953_843lwiv79j5.css');

$wei->event->trigger('beforeArticlesIndexRender');

require $app->getControllerFile('lists/' . $tpl);
