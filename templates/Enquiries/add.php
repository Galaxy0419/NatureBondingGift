<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<div class="small-container">
    <div class="enquiries form content">
        <?= $this->Form->create($enquiry) ?>
        <fieldset>
            <legend><?= __('Add Enquiry') ?></legend>
            <?= $this->Form->control('name') ?>
            <br>
            <?= $this->Form->control('email') ?>
            <br>
            <?= $this->Form->control('subject') ?>
            <br>
            <?= $this->Form->control('description', ['type' => 'textarea', 'style' => 'height: 256px']) ?>
            <br>
        </fieldset>
        <?= $this->Form->submit(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<br>
<br>
