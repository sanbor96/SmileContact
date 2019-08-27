<?php
/**
 * Contact Note save
 */
namespace Smile\Contact\Controller\Adminhtml\Note;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Smile\Contact\Api\NoteRepositoryInterface;
use Smile\Contact\Model\NoteFactory;
use Smile\Contact\Model\Note;


/**
 * Class Index
 *
 * @package Smile\Contact\Controller\Adminhtml\Note
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Contact::note_save';

    /**
     * Data persistor interface
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Note repository interface
     *
     * @var NoteRepositoryInterface
     */
    private $noteRepository;

    /**
     * Note factory
     *
     * @var NoteFactory
     */
    private $noteFactory;

    /**
     * Save constructor
     *
     * @param Action\Context          $context
     * @param DataPersistorInterface  $dataPersistor
     * @param TransportBuilder        $transportBuilder
     * @param StateInterface          $inlineTranslation
     * @param ScopeConfigInterface    $scopeConfig
     * @param StoreManagerInterface   $storeManager
     * @param NoteRepositoryInterface $noteRepository
     * @param NoteFactory             $noteFactory
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        NoteRepositoryInterface $noteRepository,
        NoteFactory $noteFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->noteRepository = $noteRepository;
        $this->noteFactory = $noteFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('id');

            try {
                $model = $this->noteRepository->getById($id);
                $model->setData($data);
                if($data['answer']) {
                    $this->sendMail($model);
                    $model->setStatus(Note::STATUS_IS_ANSWERED);
                }
                $this->noteRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Note is saved.'));
                $this->dataPersistor->clear('smile_contact_note');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while save the note.'));
            }

            $this->dataPersistor->set('smile_contact_note', $data);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $this->getRequest()->getParam('id')]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Send mail
     *
     * @param NoteRepositoryInterface $model
     */
    private function sendMail($model)
    {
        $this->inlineTranslation->suspend();

        try {
            $this->transportBuilder
                ->setTemplateIdentifier('note_email_template')
                ->setTemplateOptions($this->getTemplateOptions())
                ->setTemplateVars(
                    [
                        'comment' => $model->getComment(),
                        'answer' => $model->getAnswer()
                    ]
                )
                ->setFrom($this->getSenderInfo())
                ->addTo($model->getEmail())
                ->getTransport()
                ->sendMessage();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->inlineTranslation->resume();

        $this->messageManager->addSuccessMessage(__('E-mail is sended.'));
    }

    /**
     * Get template options
     *
     * @return array
     */
    private function getTemplateOptions()
    {
        return [
            'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
            'store' => $this->storeManager->getStore()->getId(),
        ];
    }

    /**
     * Get sender info
     *
     * @return array
     */
    private function getSenderInfo()
    {
        return [
            'name' => $this->scopeConfig->getValue(
                'trans_email/ident_support/name',
                ScopeInterface::SCOPE_STORE
            ),
            'email' => $this->scopeConfig->getValue(
                'trans_email/ident_support/email',
                ScopeInterface::SCOPE_STORE
            )
        ];
    }
}
