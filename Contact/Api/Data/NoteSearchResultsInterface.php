<?php
/**
 * Contact Note search results interface
 */
namespace Smile\Contact\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface NoteSearchResultsInterface
 *
 * @package Smile\Contact\Api\Data
 */
interface NoteSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get note list
     *
     * @return \Smile\Contact\Api\Data\NoteInterface[]
     */
    public function getItems();

    /**
     * Set note list
     *
     * @param \Smile\Contact\Api\Data\NoteInterface[] $items
     *
     * @return NoteSearchResultsInterface
     */
    public function setItems(array $items);
}
