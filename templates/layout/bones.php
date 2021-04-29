<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Natures Bonding Gift</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/lightbox.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <div class="header">
    <div class="container">
        <div class="navbar">
         <div class="logo">
        <a href=<?= $this->Url->build(['controller'=>'Landing','action'=>'home']);?>>
            <?= $this->Html->image('nbg-logo.png', array('width'=>'150px'))?>
           </a>
        </div>
        <nav>

            <ul id="MenuItems">
            <li><a href=<?= $this->Url->build(['controller'=>'Landing','action'=>'home']);?>>Home</a></li>
            <li><a href=<?= $this->Url->build(['controller'=>'Landing','action'=>'about']);?> >About</a></li>
            <li><a href="<?= $this->Url->build(['controller'=>'Enquiries','action'=>'add']);?>">Contact</a></li>
            </ul>

        </nav>
            <div class="cart-icon">
            <a href=<?= $this->Url->build(['controller'=>'Cart','action'=>'cart']);?>>
            <?= $this->Html->image('cart.png', array('width'=>'25px', 'height'=>'25px'))?>
            </a>
            </div>

            <div class="menu-icon" onclick="()">
            <img src="img/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>

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
                        <li><a href=<?= $this->Url->build(['controller'=>'Landing','action'=>'about']);?>>About </a></li>
                        <li><a href=<?= $this->Url->build(['controller'=>'Landing','action'=>'contact']);?>>Contact Us </a></li>
                        <li>Delivery</li>
                        <li>FAQ</li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
                <div class="footer-col-3">
                    <h3>Follow Us</h3>
                    <div class="icons">
                        <?= $this->Html->image('facebook.png', array('width'=>'35px', 'height'=>'35px'))?>
                        <?= $this->Html->image('instagram.png', array('width'=>'35px', 'height'=>'35px'))?>
                        <?= $this->Html->image('twitter.png', array('width'=>'35px', 'height'=>'35px'))?>
                    </div>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2021 - Natures Bonding Gift</p>
        </div>
    </div>

    <!---------JS Menu Toggle---------->
    <script>
        var MenuItems = document.getElementById("MenuItems");

        MenuItems.style.maxHeight = "0px";

        function menutoggle(){
            if(MenuItems.style.maxHeight == "0px")
                {
                    MenuItems.style.maxHeight = "200px"
                }
            else
                {
                    MenuItems.style.maxHeight = "0px";
                }
        }
    </script>

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

<script src="js/lightbox.min.js"></script>
<script>
    lightbox.option({
      'maxHeight': window.innerHeight * 0.8
    })
</script>
    </body>
</html>
