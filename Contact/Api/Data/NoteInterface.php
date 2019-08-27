<?php
/**
 * Contact Note interface
*/
namespace Smile\Contact\Api\Data;

/**
 * Interface NoteInterface
 *
 * @package Smile\Contact\Api\Data
 */
interface NoteInterface
{
    /**
     * Table name
     */
    const TABLE_NAME = 'smile_contact_note';

    /**#@+
     * Constants defined for keys of data array.
     */
    const ID         = 'id';
    const NAME       = 'name';
    const EMAIL      = 'email';
    const TELEPHONE  = 'telephone';
    const COMMENT    = 'comment';
    const CREATED_AT = 'created_at';
    const STATUS     = 'status';
    const ANSWER     = 'answer';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get e-mail
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get telephone number
     *
     * @return string
     */
    public function getTelephone();

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment();

    /**
     * Get creating time
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer();

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return NoteInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     *
     * @return NoteInterface
     */
    public function setName($name);

    /**
     * Set e-mail
     *
     * @param string $email
     *
     * @return NoteInterface
     */
    public function setEmail($email);

    /**
     * Set telephone number
     *
     * @param string $telephone
     *
     * @return NoteInterface
     */
    public function setTelephone($telephone);

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return NoteInterface
     */
    public function setComment($comment);

    /**
     * Set creating time
     *
     * @param string $createdAt
     *
     * @return NoteInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Set status
     *
     * @param int $status
     *
     * @return NoteInterface
     */
    public function setStatus($status);

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return NoteInterface
     */
    public function setAnswer($answer);
}
