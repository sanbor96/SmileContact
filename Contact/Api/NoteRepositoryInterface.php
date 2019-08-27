<?php
/**
 * Contact Note repository interface
 */
namespace Smile\Contact\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smile\Contact\Api\Data\NoteInterface;

/**
 * Interface NoteRepositoryInterface
 *
 * @package Smile\Contact\Api
 */
interface NoteRepositoryInterface
{
    /**
     * Retrieve a note by it's id
     *
     * @param $objectId
     *
     * @return NoteRepositoryInterface
     */
    public function getById($objectId);

    /**
     * Retrieve note which match a specified criteria.
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null);

    /**
     * Save note
     *
     * @param NoteInterface $object
     *
     * @return NoteRepositoryInterface
     */
    public function save(NoteInterface $object);

    /**
     * Delete a note by its id
     *
     * @param int $objectId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($objectId);
}
