<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Photo Entity
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property int $res_width
 * @property int $res_height
 * @property float $price
 * @property \Cake\I18n\FrozenTime $create_date
 * @property string $file_name
 *
 * @property \App\Model\Entity\Category $category
 */
class Photo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'category_id' => true,
        'name' => true,
        'description' => true,
        'res_width' => true,
        'res_height' => true,
        'price' => true,
        'create_date' => true,
        'file_name' => true,
        'category' => true,
    ];

    /**
     * Accessor for create_date to set timezone correctly for dates/time.
     *
     * @param FrozenTime $create_date
     * @return FrozenTime
     */
    protected function _getCreateDate(FrozenTime $create_date): FrozenTime
    {
        return $create_date->setTimezone('Australia/Melbourne');
    }
}
