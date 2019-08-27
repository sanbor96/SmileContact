<?php
/**
 * Contact Note model
 */
namespace Smile\Contact\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Contact\Api\Data\NoteInterface;

/**
 * Class Note
 *
 * @package Smile\Contact\Model\Note
 *
 */
class Note extends AbstractModel implements NoteInterface, IdentityInterface
{
    /**#@+
     * Notes Statuses
     */
    const STATUS_IS_ANSWERED = 1;
    const STATUS_NOT_ANSWERED = 0;
    /**#@-*/

    /**
     * Contact Note cache tag
     */
    const CACHE_TAG = 'smile_contact_note';

    /**
     * Cache tag
     *
     * @var string
     */
    public $cacheTag = 'smile_contact_note';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    public $eventPrefix = 'smile_contact_note';

    /**
     * Note construct
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Smile\Contact\Model\ResourceModel\Note');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve note id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get e-mail
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Get telephone number
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * Get creating time
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return NoteInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return NoteInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set e-mail
     *
     * @param string $email
     *
     * @return NoteInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set telephone number
     *
     * @param string $telephone
     *
     * @return NoteInterface
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return NoteInterface
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * Set creating time
     *
     * @param string $createdAt
     *
     * @return NoteInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return NoteInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return NoteInterface
     */
    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Prepare note statuses.
     * Available event contact_note_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_IS_ANSWERED => __('Is answered'), self::STATUS_NOT_ANSWERED => __('Not answered')];
    }
}
