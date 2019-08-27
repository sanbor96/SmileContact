<?php
/**
 * Contact Note data provider
 */
namespace Smile\Contact\Model\Note;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Smile\Contact\Model\ResourceModel\Note\CollectionFactory;

/**
 * Class DataProvider
 *
 * @package Smile\Contact\Model\Note\DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * Note collection
     *
     * @var \Smile\Contact\Model\ResourceModel\Note\Collection
     */
    protected $collection;

    /**
     * Data persistor interface
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * Loaded data
     *
     * @var array
     */
    private $loadedData;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * DataProvider constructor
     *
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param CollectionFactory      $noteCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface  $storeManager
     * @param array                  $meta
     * @param array                  $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $noteCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $noteCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if ($this->loadedData === null) {
            $this->loadedData = [];
            $items = $this->collection->getItems();

            foreach ($items as $note)
                $this->loadedData[$note->getId()] = $note->getData();

            $data = $this->dataPersistor->get('smile_contact_note');
            if (!empty($data)) {
                $note = $this->collection->getNewEmptyItem();
                $note->setData($data);
                $this->loadedData[$note->getId()] = $note->getData();
                $this->dataPersistor->clear('smile_contact_note');
            }
        }

        return $this->loadedData;
    }
}
