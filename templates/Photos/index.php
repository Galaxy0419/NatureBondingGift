<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 */
?>
<div class="photos index content">
    <?= $this->Html->link(__('New Photo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Photos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('category_id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('res_width', 'Resolution') ?></th>
                <th><?= $this->Paginator->sort('price') ?></th>
                <th><?= $this->Paginator->sort('discount_price') ?></th>
                <th><?= $this->Paginator->sort('create_date') ?></th>
                <th><?= $this->Paginator->sort('file_name', 'Preview') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($photos as $photo): ?>
                <tr>
                    <td><?= $this->Number->format($photo->id) ?></td>
                    <td><?= $photo->has('category') ? $this->Html->link($photo->category->name, ['controller' => 'Categories', 'action' => 'view', $photo->category->id]) : '' ?></td>
                    <td><?= h($photo->name) ?></td>
                    <td><?= h($photo->description) ?></td>
                    <td><?= h($photo->res_width . 'x' . $photo->res_height) ?></td>
                    <td><?= $this->Number->format($photo->price) ?></td>
                    <td>
                        <?php if (is_null($photo->discount_price)) {
                            echo "N/A";
                        } else echo $photo->discount_price; ?>
                    </td> <!--Displays an N/A if the photo has not been discounted yet. If it has, the discount price is displayed.-->
                    <td><?= h($photo->create_date) ?></td>
                    <td><?= $this->Html->image(ORIGINAL_PHOTO_PATH . '/' . $photo->file_name,
                            ['alt' => $photo->file_name]) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $photo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $photo->id],
                            ['confirm' => __('Are you sure you want to delete "{0}"?', $photo->name)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
