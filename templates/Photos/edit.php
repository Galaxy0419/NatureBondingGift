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
                    echo $this->Form->control('price');
                    echo $this->Form->control('file', [
                        'label' => 'Choose a new Photo (Optional)', 'type' => 'file', 'required' => false,
                        'accept' => 'image/jpeg,image/png', 'error' => false]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
