<?php

namespace Dito\Magento2module\Block;

use Dito\Magento2module\Helper\Config;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use Magento\Search\Model\QueryFactory;

class Magento2module extends Template
{
	/** @var Config */
    protected $configHelper;
	/** @var  CustomerSession */
    protected $customerSession;
    /** @var  CheckoutSession\ */
    protected $checkoutSession;
	/** @var  Product */
    protected $product;
    /** @var  Image */
	protected $imageHelper;
	/** @var  CollectionFactory */
    protected $categoryCollectionFactory;
    /** @var  ProductMetadataInterface */
    protected $productMetadataInterface;
	/** @var  Registry */
	protected $registry;
	/** @var array */
	protected $customerData = array();
	/** @var  Order */
	protected $orderModel;
	/** @var  QueryFactory */
	protected $queryFactory;

	public function __construct(
		Template\Context $context,
		array $data,
		Config $configHelper,
		CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
		Product $product,
		Image $imageHelper,
		CollectionFactory $categoryCollectionFactory,
        ProductMetadataInterface $productMetadataInterface,
		Registry $registry,
		Order $orderModel,
		QueryFactory $queryFactory
	) {
		$this->configHelper    = $configHelper;
		$this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
		$this->imageHelper = $imageHelper;
		$this->product = $product;
		$this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->productMetadataInterface = $productMetadataInterface;
		$this->registry = $registry;
		$this->orderModel = $orderModel;
		$this->queryFactory = $queryFactory;
		parent::__construct($context, $data);
	}

	/**
     * @return Config
     */
    public function getConfigHelper()
    {
        return $this->configHelper;
    }

	/**
     * @return array
     */
    public function getCustomerData()
    {
        if (!count($this->customerData)) {
            if ($this->customerSession->isLoggedIn()) {
                $this->getLoggedCustomerData();
            }
        }

        return $this->customerData;
	}

	/**
     * @return String
     */
	private function getUserId($customer)
	{
		$id = '';

		if ($this->configHelper->isIdTypeCpf()) {
			$cpf = $customer->getData($this->configHelper->getUserDataConfig('user_config_cpf'));

			if (empty($cpf)) {
				return;
			}

			$id = $this->formatCpf($cpf);

		} else {
			$email = $customer->getEmail();

			if (empty($email)) {
				return;
			}

			$id = sha1($this->validateEmail($customer->getEmail()));
		}

		return $id;
	}

	private function getLoggedCustomerData()
    {
		$customer                         = $this->customerSession->getCustomer();
		$this->customerData['id']         = $this->getUserId($customer);
        $this->customerData['name']       = $customer->getName();
		$this->customerData['email']      = $customer->getEmail();

		if ($this->configHelper->getCoreData('customer/address/gender_show') && $customer->getGender()) {
			$this->customerData['gender'] = array('', 'male', 'female')[$customer->getGender()];
		}

		if($customer->getDob()) {
			$this->customerData['birthday'] = explode(' ', $customer->getDob())[0];
		}

		$this->customerData['data'] = array();

		$this->customerData['data']['cpf'] = $customer->getData($this->configHelper->getUserDataConfig('user_config_cpf'));

        if ($address = $customer->getDefaultShippingAddress()) {
            $this->customerData['location']         = $address->getCity();
            $this->customerData['data']['estado']   = $address->getRegion();
            $this->customerData['data']['telefone'] = $address->getTelephone();
        } else {
            $this->customerData['data']['estado']   = '';
            $this->customerData['location']         = '';
            $this->customerData['data']['telefone'] = '';
		}

		// $subscriber = $this->subscriberHelper->loadByEmail($customer->getEmail());
        // if ($subscriber) {
        //     $this->customerData['data']['opt_in_newsletter'] = $subscriber->isSubscribed() ? "sim" : "";
        // }
	}

	/**
     * @return array
     */
	public function getCurrentCategory()
	{
		return $this->registry->registry('current_category');
	}

	/**
     * @return Image
     */
    public function getImageHelper()
    {
        return $this->imageHelper;
	}

	public function getCategoryCollection($categoryIds)
    {
        return $this->categoryCollectionFactory->create()->addIdFilter($categoryIds)->addAttributeToSelect('name');
	}

	public function getSearchTerm()
	{
		return $this->queryFactory->get()->getQueryText();
	}

	/**
     * @return bool
     */
    public function hasProductAddedToCart()
    {
        $hasBeenAdded = (bool) $this->checkoutSession->getProductHasBeenAdded();
        if ($hasBeenAdded) {
            $this->checkoutSession->unsProductHasBeenAdded();
        }
        return $hasBeenAdded;
	}

	/**
     * @return String
     */
	private function validateEmail($email) {
		return preg_replace('/\s*/', '', strtolower($email));
	}

	/**
     * @return String
     */
	private function formatCpf($valor) {
		$valor = preg_replace('/[^0-9]/', '', $valor);

		return $valor;
	}

	public function getCheckoutSession()
    {
        return $this->checkoutSession;
    }
}