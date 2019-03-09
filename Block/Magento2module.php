<?php

namespace Dito\Magento2module\Block;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\View\Element\Template;

class Magento2module extends Template
{
  	/** @var array */
	protected $customerData = array();

	public function __construct(
		Template\Context $context,
		array $data
	) {
		parent::__construct($context, $data);
	}
}