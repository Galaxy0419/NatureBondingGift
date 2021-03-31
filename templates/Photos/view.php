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
            <?= $this->Html->link(__('Edit Photo'), ['action' => 'edit', $photo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Photo'), ['action' => 'delete', $photo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $photo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Photo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="photos view content">
            <h3><?= h($photo->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $photo->has('category') ? $this->Html->link($photo->category->name, ['controller' => 'Categories', 'action' => 'view', $photo->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($photo->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($photo->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Name') ?></th>
                    <td><?= h($photo->file_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($photo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Res Width') ?></th>
                    <td><?= $this->Number->format($photo->res_width) ?></td>
                </tr>
                <tr>
                    <th><?= __('Res Height') ?></th>
                    <td><?= $this->Number->format($photo->res_height) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($photo->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Date') ?></th>
                    <td><?= h($photo->create_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
