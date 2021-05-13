<!---------Products Section-------------->
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 */
?>

<div class="small-container">
    <h2 class="title">All Photos</h2>

    <div class="row">
        <div class="col-sm-1">
            <h4>Categories:</h4>
        </div>
        <?= $this->Html->link('All', ['action' => 'home', null], ['class' => 'button']) ?>
        <?php foreach ($categories as $category): ?>
            <?= $this->Html->link(ucfirst($category->name), ['action' => 'home', $category->id], ['class' => 'button']) ?>
        <?php endforeach; ?>
    </div>

    <br><br>

    <div class="row">
        <?php if ($photos->count() == 0): ?>
            <br>
            <h4>There are no photos matching this category currently</h4>
        <?php else: ?>
            <?php foreach ($photos as $photo): ?>
                <!--
                    For loop will cycle through all the photos in the database object passed from LandingController.php
                    and display them on the page.  The code below sets a string variable containing the path to the watermarked photo.
                -->
                <div class="col-4">
                    <?= $this->Html->link($this->Html->image(WATERMARK_PHOTO_PATH . '/' . $photo->file_name),
                        'img' . '/' . WATERMARK_PHOTO_PATH . '/' . $photo->file_name,
                        ['escape' => false, 'data-lightbox' => 'gallery', 'data-title' => $photo->description .
                            '<br>' . 'Resolution:' . $photo->res_width . 'x' .  $photo->res_height]) ?>

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
                    <?= $this->Html->link('Add to Cart', ['action' => 'addToCart', $photo->id], ['class' => 'button']) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<br><br>

<script type="text/javascript">
    document.addEventListener("contextmenu", function (e) {
        if (e.target.nodeName === "IMG") {
            e.preventDefault();
            alert("Copying images is disabled for this page.");
        }
    });
</script>
