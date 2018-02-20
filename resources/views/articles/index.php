<?php

$view->layout();

require $app->getControllerFile('lists/' . $tpl);
