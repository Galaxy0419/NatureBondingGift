<!---------Products Section-------------->
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 */
?>

<div class="small-container">
    <h2 class="title">All Photos</h2>
    <div class="row">
        <?php foreach ($photos as $photo): ?>
            <!--
                For loop will cycle through all the photos in the database object passed from LandingController.php
                and display them on the page.  The code below sets a string variable containing the path to the watermarked photo.
            -->
            <div class="col-4">
                <?= $this->Html->link($this->Html->image(WATERMARK_PHOTO_PATH . '/' . $photo->file_name),
                    'img' . '/' . WATERMARK_PHOTO_PATH . '/' . $photo->file_name,
                    ['escape' => false, 'data-lightbox' => 'gallery', 'data-title' => $photo->description]) ?>

                <h4><?= $photo->name ?></h4>

                <!--
                    Display photo price. Original price is struck and discounted price and percentage is displayed
                    only if the product has been discounted.  Otherwise, the original price is shown.
                -->
                <?php
                    if (!is_null($photo->discount_price) and $photo->price > $photo->discount_price) {
                        $discount_percent = round((1 - ($photo->discount_price / $photo->price)) * 100);
                        echo '<s>$' . $this->Number->precision($photo->price, 2) . '</s>'
                            . ' $' . $this->Number->precision($photo->discount_price, 2) . ' <b>' . $discount_percent . '% OFF!! </b>';
                    } else {
                        echo '$' . $this->Number->precision($photo->price, 2);
                    }
                ?>

                <p><?= ucfirst($photo->category->name) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener("contextmenu", function (e) {
        if (e.target.nodeName === "IMG") {
            e.preventDefault();
            alert("Copying images is disabled for this page.");
        }
    });
</script>

