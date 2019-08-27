<?php
/**
 * Contact Note repository
 */
namespace Smile\Contact\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\Contact\Api\Data;
use Smile\Contact\Api\NoteRepositoryInterface;
use Smile\Contact\Model\ResourceModel\Note as ResourceNote;
use Smile\Contact\Model\ResourceModel\Note\CollectionFactory as NoteCollectionFactory;

/**
 * Class NoteRepository
 *
 * @package Smile\Contact\Model\NoteRepository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class NoteRepository implements NoteRepositoryInterface
{
    /**
     * Resource note
     *
     * @var ResourceNote
     */
    private $resource;

    /**
     * Note factory
     *
     * @var NoteFactory
     */
    private $noteFactory;

    /**
     * Note collection factory
     *
     * @var NoteCollectionFactory
     */
    private $noteCollectionFactory;

    /**
     * Note search results interface factory
     *
     * @var NoteSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * NoteRepository constructor
     *
     * @param ResourceNote                           $resource
     * @param NoteFactory                            $noteFactory
     * @param NoteCollectionFactory                  $noteCollectionFactory
     * @param Data\NoteSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ResourceNote $resource,
        NoteFactory $noteFactory,
        NoteCollectionFactory $noteCollectionFactory,
        Data\NoteSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->noteFactory = $noteFactory;
        $this->noteCollectionFactory = $noteCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Note data
     *
     * @param \Smile\Contact\Api\Data\NoteInterface $note
     *
     * @return Note
     *
     * @throws CouldNotSaveException
     */
    public function save(Data\NoteInterface $note)
    {
        try {
            $this->resource->save($note);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $note;
    }

    /**
     * Load Note data by given Note Identity
     *
     * @param string $noteId
     *
     * @return Note
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($noteId)
    {
        $note = $this->noteFactory->create();
        $this->resource->load($note, $noteId);
        if (!$note->getId()) {
            throw new NoSuchEntityException(__('Note with id "%1" does not exist.', $noteId));
        }

        return $note;
    }

    /**
     * Load Note data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     *
     * @return \Smile\Contact\Model\ResourceModel\Note\Collection
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria = null)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->noteCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $note = [];
        /** @var Data\NoteInterface $noteModel */
        foreach ($collection as $noteModel) {
            $note[] = $noteModel;
        }
        $searchResults->setItems($note);

        return $searchResults;
    }

    /**
     * Delete Note
     *
     * @param \Smile\Contact\Api\Data\NoteInterface $note
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function delete(Data\NoteInterface $note)
    {
        try {
            $this->resource->delete($note);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Note by given Note Identity
     *
     * @param string $noteId
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($noteId)
    {
        return $this->delete($this->getById($noteId));
    }
}
