<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo $photo
 */
?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $photo->id],
                ['confirm' => __('Are you sure you want to delete "{0}"?', $photo->name), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="photos form content">
            <?= $this->Form->create($photo, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Edit Photo') ?></legend>
                <?php
                echo $this->Html->link('Add', 'categories/add', ['class' => 'button', 'style' => 'float:right']);
                echo $this->Form->control('category_id', ['options' => $categories]);
                echo $this->Form->control('name');
                echo $this->Form->control('description');
                echo $this->Form->control('price', ['id' => 'price']);
                echo $this->Form->control('discount_price', ['id' => 'discount_price']);;
                echo $this->Form->control('Discount Percentage', ['id' => 'discount_percentage']);
                echo $this->Form->control('file', [
                    'label' => 'Choose a new Photo (Optional)', 'type' => 'file', 'required' => false,
                    'accept' => 'image/jpeg,image/png', 'error' => false]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<script>
    $('#price').change(function () {
        $('#discount_price').val('');
        $('#discount_percentage').val('');
    });
    //sets discount price and percentage to null as any changes to the original price should override any previously set discount prices.

    $('#discount_price').change(function () {
        if ($('#discount_price').val()>$('#price').val()){
            $('#discount_price').val('');
            alert("Discount price entered is greater than the original price. If you wish to increase the price, please modify the original price instead.")
        }
        var percentage = Math.round((1 - (parseFloat($('#discount_price').val()) / parseFloat($('#price').val()))) * 100);
        $('#discount_percentage').val(percentage + '%');
    });

    $('#discount_percentage').change(function () {
        if (parseFloat($('#discount_percentage').val()) < 0 || parseFloat($('#discount_percentage').val()) > 100){
            $('#discount_percentage').val('');
            alert("Please enter a value between 0 and 100%. E.g.: To apply a 20% discount, enter 20.");
        }
        else {
            let discountedPrice = parseFloat($('#price').val()) * (1 - parseFloat($('#discount_percentage').val()) / 100);
            $('#discount_price').val(discountedPrice.toFixed(2));
        }
    });


</script>
