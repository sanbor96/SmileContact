<?php
/**
 * Contact Note status
 */
namespace Smile\Contact\Model\Note\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Smile\Contact\Model\Note;

/**
 * Class Status
 *
 * @package Smile\Contact\Model\Note\Source\Status
 */
class Status implements OptionSourceInterface
{
    /**
     * Note
     *
     * @var Note
     */
    private $note;

    /**
     * Status constructor
     *
     * @param Note $note
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->note->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
