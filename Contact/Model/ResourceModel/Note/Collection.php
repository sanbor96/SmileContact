<?php
/**
 * Contact Note collection
 */
namespace Smile\Contact\Model\ResourceModel\Note;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Smile\Contact\Model\ResourceModel\Note\Collection
 *
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Smile\Contact\Model\Note', 'Smile\Contact\Model\ResourceModel\Note');
    }
}
