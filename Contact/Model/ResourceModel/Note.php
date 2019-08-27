<?php
/**
 * Contact Note resource model
 */
namespace Smile\Contact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Note
 *
 * @package Smile\Contact\Model\ResourceModel\Note
 */
class Note extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('smile_contact_note', 'id');
    }
}
