<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <title>Home - Natures Bonding Gift</title>


    <?= $this->Html->meta('icon', 'img/nbg-logo.png') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'bootstrap', 'lightbox', 'rubik-font.css', 'style']) ?>
    <?= $this->Html->script(['jquery.min', 'lightbox.min']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href=<?= $this->Url->build(['controller' => 'Landing', 'action' => 'home']) ?>>
                    <?= $this->Html->image('nbg-logo.png', array('width' => '150px')) ?>
                </a>
            </div>

            <nav>
                <ul style="max-height: 0">
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'Landing', 'action' => 'home']) ?>>Home</a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'Landing', 'action' => 'about']) ?>>About</a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Enquiries', 'action' => 'add']) ?>">Contact</a>
                    </li>
                </ul>
                <a href=<?= $this->Url->build(['controller'=>'Landing','action'=>'cart']);?>>
                    <i class="fas fa-shopping-cart"></i> Cart
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
                <div class="footer-logo">
                    <?= $this->Html->image('ngbwhite.png') ?>
                    <p> Our Purpose Is To Find You A Gift Of Nature.</p>
                </div>
            </div>

            <div class="footer-col-2">
                <h3>Useful Links</h3>
                <ul>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'Landing', 'action' => 'about']) ?>>About </a>
                    </li>
                    <li>
                        <a href=<?= $this->Url->build(['controller' => 'Enquiries', 'action' => 'add']) ?>>Contact Us</a>
                    </li>
                    <li>Delivery</li>
                    <li>FAQ</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>

            <div class="footer-col-3">
                <h3>Follow Us</h3>
                <div class="icons">
                    <?= $this->Html->image('facebook.png', array('width' => '35px', 'height' => '35px')) ?>
                    <?= $this->Html->image('instagram.png', array('width' => '35px', 'height' => '35px')) ?>
                    <?= $this->Html->image('twitter.png', array('width' => '35px', 'height' => '35px')) ?>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright">Copyright 2021 - Natures Bonding Gift</p>
    </div>
</div>

<script>
    lightbox.option({
        'maxHeight': window.innerHeight * 0.8
    })
</script>
</body>
</html>
