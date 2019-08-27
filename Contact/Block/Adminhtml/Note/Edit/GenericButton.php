<?php
/**
 * Contact Note generic button
 */
namespace Smile\Contact\Block\Adminhtml\Note\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\Contact\Api\NoteRepositoryInterface;

/**
 * Class GenericButton
 *
 * @package Smile\Contact\Block\Adminhtml\Note\Edit
 */
class GenericButton
{
    /**
     * Context
     *
     * @var Context
     */
    private $context;

    /**
     * Note repository interface
     *
     * @var NoteRepositoryInterface
     */
    private $noteRepository;

    /**
     * GenericButton constructor
     *
     * @param Context                 $context
     * @param NoteRepositoryInterface $noteRepository
     */
    public function __construct(
        Context $context,
        NoteRepositoryInterface $noteRepository
    ) {
        $this->context = $context;
        $this->noteRepository = $noteRepository;
    }

    /**
     * Get Note ID
     *
     * @return int
     */
    public function getNoteId()
    {
        try {
            $modelId = $this->context->getRequest()->getParam('id');

            return $this->noteRepository->getById($modelId)->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array  $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
