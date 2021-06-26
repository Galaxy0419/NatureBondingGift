<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <?= $this->Html->meta('icon', 'img/nbg-logo.png') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
<nav class="top-nav">
    <div class="top-nav-title">
        <?= $this->Html->link('<span>Admin</span>Panel', ['controller' => 'Landing', 'action' => 'home'], ['escape' => false]) ?>
    </div>

    <div class="top-nav-links">
        <?= $this->Html->link('Home', ['controller' => 'Landing', 'action' => 'home']) ?>
        <?= $this->Html->link('Categories', ['controller' => 'Categories']) ?>
        <?= $this->Html->link('Photos', ['controller' => 'Photos']) ?>
        <?= $this->Html->link('Enquiries', ['controller' => 'Enquiries']) ?>
        <?= $this->Html->link('Admins', ['controller' => 'Admins']) ?>
        <?= $this->Html->link('Logout', ['controller' => 'Admins', 'action' => 'logout']) ?>
    </div>
</nav>

<main class="main">
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</main>

<footer>
</footer>
</body>
</html>
