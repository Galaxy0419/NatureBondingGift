<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo $photo
 */
?>

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
    const price = document.getElementById('price')
    const discountPrice = document.getElementById('discount_price')
    const discountPercentage = document.getElementById('discount_percentage')

    price.addEventListener('change', () => {
        discountPrice.value = '';
        discountPercentage.value = '';
    });

    discountPrice.addEventListener('change', () => {
        if (price.value !== "") {
            console.log(price.value);
            console.log(discountPrice.value);
            if (discountPrice.value < price.value) {
                discountPercentage.value = (1 - discountPrice.value / price.value) * 100;
            } else {
                alert('Discount price must be less than original price!');
            }
        } else {
            alert("Original price is empty. Please enter original price first.")
        }
    });

    discountPercentage.addEventListener('change', () => {
        if (price.value !== "") {
            if (discountPercentage.value > 0 && discountPercentage.value < 100) {
                discountPrice.value = price.value * (1 - discountPercentage.value / 100);
            } else {
                alert('Discount percentage must be between 0 and 100!');
            }
        } else {
            alert("Original price is empty. Please enter original price first.")
        }
    });
</script>
