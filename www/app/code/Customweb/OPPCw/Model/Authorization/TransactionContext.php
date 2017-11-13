<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2016 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 *
 * @category	Customweb
 * @package		Customweb_OPPCw
 *
 */

namespace Customweb\OPPCw\Model\Authorization;

class TransactionContext implements
	\Customweb_Payment_Authorization_ITransactionContext,
	\Customweb_Payment_Authorization_PaymentPage_ITransactionContext,
	\Customweb_Payment_Authorization_Hidden_ITransactionContext,
	\Customweb_Payment_Authorization_Iframe_ITransactionContext,
	\Customweb_Payment_Authorization_Server_ITransactionContext,
	\Customweb_Payment_Authorization_Moto_ITransactionContext,
	\Customweb_Payment_Authorization_Ajax_ITransactionContext,
	\Customweb_Payment_Authorization_Widget_ITransactionContext,
	\Customweb_Payment_Authorization_IUpdateTransactionContext
{
	/**
	 * @var \Customweb\OPPCw\Model\Authorization\TransactionFactory
	 */
	private $_transactionFactory;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\CustomerContextFactory
	 */
	private $_customerContextFactory;

	/**
	 * @var int
	 */
	private $transactionId;

	/**
	 * @var int
	 */
	private $orderId;

	/**
	 * @var int
	 */
	private $aliasTransactionId = null;

	/**
	 * @var string
	 */
	private $backendSuccessUrl;

	/**
	 * @var string
	 */
	private $backendFailureUrl;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\OrderContext
	 */
	private $orderContext;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\Transaction
	 */
	private $cachedTransaction;

	/**
	 * @var \Customweb_Payment_Authorization_ITransaction
	 */
	private $cachedAliasTransactionObject;

	/**
	 * @param \Magento\Backend\Helper\Data $backendHelper
	 * @param \Customweb\OPPCw\Model\Authorization\TransactionFactory $transactionFactory
	 * @param \Customweb\OPPCw\Model\Authorization\CustomerContextFactory $customerContextFactory
	 * @param \Customweb\OPPCw\Model\Authorization\Transaction $transaction
	 * @param \Customweb\OPPCw\Model\Authorization\OrderContext $orderContext
	 * @param int $orderId
	 * @param int|string $aliasTransactionId
	 */
	public function __construct(
			\Magento\Backend\Helper\Data $backendHelper,
			\Customweb\OPPCw\Model\Authorization\TransactionFactory $transactionFactory,
			\Customweb\OPPCw\Model\Authorization\CustomerContextFactory $customerContextFactory,
			\Customweb\OPPCw\Model\Authorization\Transaction $transaction,
			\Customweb\OPPCw\Model\Authorization\OrderContext $orderContext,
			$orderId,
			$aliasTransactionId = null
	) {
		$this->_transactionFactory = $transactionFactory;
		$this->_customerContextFactory = $customerContextFactory;

		$this->cachedTransaction = $transaction;
		$this->transactionId = $transaction->getId();
		$this->orderContext = $orderContext;
		$this->orderId = $orderId;
		$this->aliasTransactionId = $aliasTransactionId;
		$this->backendSuccessUrl = $backendHelper->getUrl('oppcw/checkout/success');
		$this->backendFailureUrl = $backendHelper->getUrl('oppcw/checkout/failure');
	}

	/**
	 * @return string[]
	 */
	public function __sleep()
	{
		$properties = array_keys(get_object_vars($this));
		$properties = array_diff($properties, ['_transactionFactory', '_customerContextFactory', 'cachedCustomerContext', 'cachedTransaction', 'cachedAliasTransactionObject']);
		return $properties;
	}

	/**
	 * Init not serializable fields
	 *
	 * @return void
	 */
	public function __wakeup()
	{
		$this->_transactionFactory = \Magento\Framework\App\ObjectManager::getInstance()->get('Customweb\OPPCw\Model\Authorization\TransactionFactory');
		$this->_customerContextFactory = \Magento\Framework\App\ObjectManager::getInstance()->get('Customweb\OPPCw\Model\Authorization\CustomerContextFactory');
	}

	public function getOrderContext()
	{
		return $this->orderContext;
	}

	public function getTransactionId()
	{
		return $this->transactionId;
	}

	public function getOrderId()
	{
		return $this->orderId;
	}

	public function isOrderIdUnique()
	{
		return true;
	}

	public function getCapturingMode()
	{
		return null;
	}

	public function getAlias()
	{
		if ($this->getOrderContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('alias_manager') !== 'active') {
			return null;
		}

		if ($this->aliasTransactionId == 'new') {
			return 'new';
		}

		if ($this->aliasTransactionId !== null) {
			if (!($this->cachedAliasTransactionObject instanceof \Customweb_Payment_Authorization_ITransaction)) {
				$this->cachedAliasTransactionObject = $this->_transactionFactory->create()->load($this->aliasTransactionId)->getTransactionObject();
			}
			return $this->cachedAliasTransactionObject;
		}

		return null;
	}

	public function createRecurringAlias()
	{
		return false;
	}

	public function getCustomParameters()
	{
		return [
			'cstrxid' => $this->getTransactionId()
		];
	}

	public function getPaymentCustomerContext()
	{
		return $this->_customerContextFactory->createWithCustomerId($this->getOrderContext()->getCustomerId());
	}

	public function getSuccessUrl()
	{
		return $this->getTransaction()->getStore()->getUrl('oppcw/checkout/success', ['_secure' => true]);
	}

	public function getFailedUrl()
	{
		return $this->getTransaction()->getStore()->getUrl('oppcw/checkout/failure', ['_secure' => true]);
	}

	public function getIframeBreakOutUrl()
	{
		return $this->getTransaction()->getStore()->getUrl('oppcw/checkout/breakout', ['_secure' => true]);
	}

	public function getBackendSuccessUrl()
	{
		return $this->backendSuccessUrl;
	}

	public function getBackendFailedUrl()
	{
		return $this->backendFailureUrl;
	}

	public function getJavaScriptSuccessCallbackFunction()
	{
		return "function(url){window.location = url;}";
	}

	public function getJavaScriptFailedCallbackFunction()
	{
		return "function(url){window.location = url;}";
	}

	/**
	 * @return \Customweb\OPPCw\Model\Authorization\Transaction
	 */
	public function getTransaction()
	{
		if (!($this->cachedTransaction instanceof \Customweb\OPPCw\Model\Authorization\Transaction)) {
			$this->cachedTransaction = $this->_transactionFactory->create()->load($this->getTransactionId());
		}
		return $this->cachedTransaction;
	}
}