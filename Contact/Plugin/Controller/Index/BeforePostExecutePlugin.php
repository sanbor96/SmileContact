<?php
/**
 * Save into database customer note
 */
namespace Smile\Contact\Plugin\Controller\Index;

use Magento\Contact\Controller\Index\Post as ContactIndexPost;
use Magento\Framework\App\Action\Context;
use Smile\Contact\Api\NoteRepositoryInterface;
use Smile\Contact\Model\NoteFactory;

/**
 * Class BeforePostExecutePlugin
 *
 * @package Smile\Contact\Plugin\Controller\Index
 */
class BeforePostExecutePlugin
{
    /**
     * Note repository interface
     *
     * @var NoteRepositoryInterface
     */
    protected $noteRepository;

    /**
     * Note factory
     *
     * @var NoteFactory
     */
    protected $noteFactory;

    /**
     * Message manager
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    public function __construct(
        Context $context,
        NoteRepositoryInterface $noteRepository,
        NoteFactory $noteFactory
    ) {
        $this->noteRepository = $noteRepository;
        $this->noteFactory = $noteFactory;
        $this->messageManager = $context->getMessageManager();
    }

    /**
     * Before "beforeExecute"
     *
     * @param ContactIndexPost $subject Subject
     */
    public function beforeExecute(ContactIndexPost $subject)
    {
        try{
            $data = $subject->getRequest()->getPostValue();
            $model = $this->noteFactory->create();
            $model->setData($data);
            $this->noteRepository->save($model);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}
