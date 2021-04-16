<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Natures Bonding Gift</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
    <div class="container">
        <div class="navbar">
         <div class="logo">
            <?= $this->Html->image('nbg-logo.png', array('width'=>'150px'))?>
        </div>
        <nav>
            <ul id="MenuItems">
            <li><a href="">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Contact</a></li>
            </ul>
        </nav>
            <div class="cart-icon">
            <?= $this->Html->image('cart.png', array('width'=>'25px', 'height'=>'25px'))?>
            </div>
            <!-----------
            <div class="menu-icon" onclick="()">
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            <?= $this->Html->image('menu.png')?>
            </div>
            ---------->
        </div>

    <div class="row">
        <div class="col-2">

        </div>
        <div class="col-2">

        </div>
    </div>
</div>
</div>

<?= $this->fetch('content') ?>
<?= $this->Html->css(['style', 'bootstrap']) ?>


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
                        <li>About</li>
                        <li>Contact Us</li>
                        <li>Delivery</li>
                        <li>FAQ</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
                <div class="footer-col-3">
                    <h3>Follow Us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Instagram</li>
                        <li>Twitter</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2021 - Natures Bonding Gift</p>
        </div>
    </div>
    <script type="text/javascript">

        document.addEventListener("contextmenu",function(disable){
            disable.preventDefault()
        });

        document.addEventListener("mousedown", function(rclick) {
            if (rclick.which === 3) {

                alert("Copying photos is not enabled.");
            }
        });
    </script>
    </body>
</html>
