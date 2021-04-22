<!---------Single Photo Details-------------->
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 */
?>
<div class="small-container">
        <h2 class="title">All Photos</h2>
        <div class="row">
                <?php foreach ($photos as $photo){
                echo '<div class="col-4">';
                /*For loop will cycle through all the photos in the database object passed from LandingController.php and display them on the page.
                * the code below sets a string variable containing the path to the watermarked photo.*/
                $imagePath = WATERMARK_PHOTO_PATH."/".$photo->file_name; ?>
                <?php echo $this->Html->image($imagePath)?>
                <?php echo '</div>' ?>
                <h4><?php echo $photo->name; ?></h4> 
                <p><?php echo $photo->price; ?></p> 
                
                <?php } ?>
            </div>

        </div>
