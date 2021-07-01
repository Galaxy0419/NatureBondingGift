<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Natures Bonding Gift</title>

    <?= $this->Html->meta('icon', 'img/logo.png') ?>
    <?= $this->Html->css(['cake', 'bootstrap.min', 'lightbox', 'style']) ?>
    <?= $this->Html->script(['jquery.min', 'lightbox.min']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-5">
    <div class="container">
        <div class="navbar-brand">
            <?= $this->Html->image('logo.png', ['width' => '96px']) ?>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Landing', 'action' => 'home']) ?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Landing', 'action' => 'about']) ?>" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Enquiries', 'action' => 'add']) ?>" class="nav-link">Enquiry</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Landing', 'action' => 'cart']) ?>" class="nav-link">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>

<footer class="footer bg-dark">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-5">
                <?= $this->Html->image('logo.png', ['width' => '128px']) ?>
                <p class="text-light">Our Purpose Is To Find You A Gift Of Nature.</p>
            </div>

            <div class="col-4">
                <ul class="list-unstyled">
                    <li><h3>Useful Links</h3></li>
                    <li>
                        <a class="link-light" href=<?= $this->Url->build(['controller' => 'Landing', 'action' => 'about']) ?>>About </a><br>
                    </li>
                    <li>
                        <a class="link-light" href=<?= $this->Url->build(['controller' => 'Enquiries', 'action' => 'add']) ?>>Contact Us</a><br>
                    </li>
                    <li class="text-light">Delivery</li>
                    <li class="text-light">FAQ</li>
                    <li class="text-light">Privacy Policy</li>
                </ul>
            </div>

            <div class="col-3">
                <h3>Follow Us</h3>
                <?= $this->Html->image('facebook.png', ['width' => '32px', 'height' => '32px']) ?>
                <?= $this->Html->image('instagram.png', ['width' => '32px', 'height' => '32px']) ?>
                <?= $this->Html->image('twitter.png', ['width' => '32px', 'height' => '32px']) ?>
            </div>
        </div>

        <hr class="bg-light">
        <p class="text-light text-center pb-4 m-0">Copyright 2021 - Natures Bonding Gift</p>
    </div>
</footer>

<script>
    lightbox.option({
        'maxHeight': window.innerHeight * 0.8
    })
</script>
</body>
</html>
