{"filter":false,"title":"default.ctp","tooltip":"/src respaldo/Template/Layout/default.ctp","undoManager":{"mark":1,"position":1,"stack":[[{"start":{"row":0,"column":0},"end":{"row":45,"column":0},"action":"remove","lines":["<?php","/**"," * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)"," * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)"," *"," * Licensed under The MIT License"," * For full copyright and license information, please see the LICENSE.txt"," * Redistributions of files must retain the above copyright notice."," *"," * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)"," * @link          http://cakephp.org CakePHP(tm) Project"," * @since         0.10.0"," * @license       http://www.opensource.org/licenses/mit-license.php MIT License"," */","","$cakeDescription = 'San Gabriel Arcángel';","?>","<!DOCTYPE html>","<html>","<head>","    <?= $this->Html->charset() ?>","    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">","    <title>","        <?= $cakeDescription ?>","    </title>","    <?= $this->Html->meta('icon') ?>","","    <?= $this->Html->css(['jquery-ui.min', 'bootstrap.min', 'style']) ?>","    <?= $this->Html->script(['jquery-3.1.1.min', 'jquery-ui.min', 'bootstrap.min', 'jquery.redirect', 'jquery.numeric.min']) ?>","    ","    <?= $this->fetch('meta') ?>","    <?= $this->fetch('css') ?>","    <?= $this->fetch('script') ?>","</head>","<body>","    <?= $this->element('menu') ?>","    ","    <?= $this->Flash->render() ?>","    <div class=\"container\">","        <?= $this->fetch('content') ?>","    </div>","    <footer>","    </footer>","</body>","</html>",""],"id":114}],[{"start":{"row":0,"column":0},"end":{"row":44,"column":7},"action":"insert","lines":["<?php","/**"," * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)"," * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)"," *"," * Licensed under The MIT License"," * For full copyright and license information, please see the LICENSE.txt"," * Redistributions of files must retain the above copyright notice."," *"," * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)"," * @link          http://cakephp.org CakePHP(tm) Project"," * @since         0.10.0"," * @license       http://www.opensource.org/licenses/mit-license.php MIT License"," */","","$cakeDescription = 'San Gabriel Arcángel';","?>","<!DOCTYPE html>","<html>","<head>","    <?= $this->Html->charset() ?>","    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">","    <title>","        <?= $cakeDescription ?>","    </title>","    <?= $this->Html->meta('icon') ?>","","    <?= $this->Html->css(['jquery-ui.min', 'bootstrap.min', 'style']) ?>","    <?= $this->Html->script(['jquery-3.1.1.min', 'jquery-ui.min', 'bootstrap.min', 'jquery.redirect', 'jquery.numeric.min']) ?>","    ","    <?= $this->fetch('meta') ?>","    <?= $this->fetch('css') ?>","    <?= $this->fetch('script') ?>","</head>","<body>","    <?= $this->element('menu') ?>","    ","    <?= $this->Flash->render() ?>","    <div class=\"container\">","        <?= $this->fetch('content') ?>","    </div>","    <footer>","    </footer>","</body>","</html>"],"id":115}]]},"ace":{"folds":[],"scrolltop":120,"scrollleft":0,"selection":{"start":{"row":44,"column":7},"end":{"row":44,"column":7},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":{"row":9,"state":"php-doc-start","mode":"ace/mode/php"}},"timestamp":1505155493840,"hash":"7a69a46105acda3dc60e51a62b504a606fbbfc0a"}