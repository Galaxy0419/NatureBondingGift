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
            <div class="col-4">
                <?php foreach ($photos as $photo){ ?>
<!--                <img src="images/photo1.png">-->
                <h4><?php echo $photo->name; ?></h4>
                <p>$<?php echo $photo->price; ?></p>

                <?php } ?>
            </div>

        </div>
    </div>
