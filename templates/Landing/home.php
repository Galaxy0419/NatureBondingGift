<!---------Products Section-------------->
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 */
?>
<html>
<head>
</head>
    <body>
<div class="small-container">
    <h2 class="title">All Photos</h2>
    <div class="row">
        <?php foreach ($photos as $photo) {
            /*For loop will cycle through all the photos in the database object passed from LandingController.php and display them on the page.
            * the code below sets a string variable containing the path to the watermarked photo.*/
            $imagePath = WATERMARK_PHOTO_PATH . "/" . $photo->file_name; ?>
            <?php echo '<div class="col-4">'; ?>
            <a class="test" data-lightbox="gallery" data-title='<?= $photo->description ."<br>" . 'Resolution:' . $photo->res_width . 'x' .  $photo->res_height?>' href='img/<?= ($imagePath)?>'>
            <?= $this->Html->image($imagePath)?> 
            </a>
            <h4><?php echo $photo->name; ?></h4>  <!-displays photo name-->
            <?php if (!is_null($photo->discount_price) and $photo->price > $photo->discount_price) {
                $discount_percent = round((1 - ($photo->discount_price / $photo->price)) * 100);
                ?>
                <p> <?php echo '<s>$' . $this->Number->precision($photo->price,2) . '</s>' . ' $' . $this->Number->precision($photo->discount_price,2) . ' <b>' .
                    $discount_percent . '% OFF!! </b>';
            } else {
                echo '$' . $this->Number->precision($photo->price,2);
            } ?>
            </p><!-displays photo price. Original price is striked and discounted price and percentage is displayed only if the product has been discounted.
                Otherwise, the original price is shown.-->
            <p><?php echo ucfirst($photo->category->name); ?></p>  <!-displays photo category-->
            <?php echo '</div>'; ?>
            <?php
        } ?>
    </div>
    
            </div>

    </body>

<script type="text/javascript">
    document.addEventListener("contextmenu", function(e) {
        if (e.target.nodeName === "IMG") {
            e.preventDefault();
            alert("Copying images is disabled for this page.");
        }
    });
</script>

</html>

<?= $photo->res_width?> . 'x' . <?= $photo->res_height?>