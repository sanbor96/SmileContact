<?php
/**
 * Contact Note delete
 */
namespace Smile\Contact\Controller\Adminhtml\Note;

use Magento\Backend\App\Action;
use Smile\Contact\Api\NoteRepositoryInterface;

/**
 * Class Delete
 *
 * @package Smile\Contact\Controller\Adminhtml\Note
 */
class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Contact::note_delete';

    /**
     * Note repository interface
     *
     * @var NoteRepositoryInterface
     */
    private $noteRepository;

    /**
     * Delete constructor
     *
     * @param Action\Context          $context
     * @param NoteRepositoryInterface $noteRepository
     */
    public function __construct(
        Action\Context          $context,
        NoteRepositoryInterface $noteRepository
    ) {
        $this->noteRepository = $noteRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $noteRepository = $this->noteRepository;
                $noteRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The note has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a note to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
