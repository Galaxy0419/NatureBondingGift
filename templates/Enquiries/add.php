<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<div class="column-responsive column-80">
    <div class="enquiries form content">
        <?= $this->Form->create($enquiry) ?>
        <fieldset>
            <legend><?= __('Add Enquiry') ?></legend>
            <?php
                echo $this->Form->control('name');
                echo $this->Form->control('email');
                echo $this->Form->control('subject');
                echo $this->Form->control('description', ['type' => 'textarea', 'style' => 'height: 256px']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
