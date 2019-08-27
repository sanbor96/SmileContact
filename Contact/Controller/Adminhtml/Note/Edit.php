<?php
/**
 * Contact Note edit
 */
namespace Smile\Contact\Controller\Adminhtml\Note;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Smile\Contact\Api\NoteRepositoryInterface;

/**
 * Class Edit
 *
 * @package Smile\Contact\Controller\Adminhtml\Note
 */
class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Contact::note_save';

    /**
     * Core registry
     *
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Page factory
     *
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Note repository interface
     *
     * @var NoteRepositoryInterface
     */
    private $noteRepository;

    /**
     * Edit constructor
     *
     * @param Action\Context          $context
     * @param PageFactory             $resultPageFactory
     * @param Registry                $registry
     * @param NoteRepositoryInterface $noteRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        NoteRepositoryInterface $noteRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->noteRepository = $noteRepository;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    private function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_contact::note')
            ->addBreadcrumb(__('Smile'), __('Smile'))
            ->addBreadcrumb(__('Manage Notes'), __('Manage Notes'));

        return $resultPage;
    }

    /**
     * Edit Note page
     *
     * @return \Magento\Backend\Model\View\Result\Page | \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('id');
        $resultPage->getConfig()->getTitle()->prepend(__('Note Information'));

        if ($id) {
            try {
                $model = $this->noteRepository->getById($id);
                $resultPage->getConfig()->getTitle()->prepend(__('Edit Note'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while editing the note.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
            $this->coreRegistry->register('contact_note', $model);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            __('Edit Note'),
            __('Edit Note')
        );

        return $resultPage;
    }
}
