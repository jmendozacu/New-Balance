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

namespace Customweb\OPPCw\Model\Authorization\Method;

abstract class AbstractMethod
{
	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	protected $_logger;

	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

	/**
	 * @var \Magento\Sales\Model\Order\Email\Sender\OrderSender
	 */
	protected $_orderSender;

	/**
	 * @var \Magento\Sales\Model\Order\Email\Sender\InvoiceSender
	 */
	protected $_invoiceSender;

	/**
	 * @var \Customweb\OPPCw\Model\DependencyContainer
	 */
	protected $_container;

	/**
	 * @var \Customweb\OPPCw\Model\Alias\Handler
	 */
	protected $_aliasHandler;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\TransactionContextFactory
	 */
	protected $_transactionContextFactory;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\TransactionFactory
	 */
	protected $_transactionFactory;

	/**
	 * @var \Customweb\OPPCw\Model\ResourceModel\Authorization\Transaction\CollectionFactory
	 */
	protected $_transactionCollectionFactory;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\Method\Context\Factory
	 */
	protected $_contextFactory;

	/**
	 * @var \Magento\Checkout\Model\Session
	 */
	protected $_checkoutSession;

	/**
	 * @var \Customweb_Payment_Authorization_IAdapter
	 */
	private $interfaceAdapter;

	/**
	 * @var \Customweb\OPPCw\Model\Authorization\Method\Context\IContext
	 */
	private $context;

	/**
	 * @param \Psr\Log\LoggerInterface $logger
	 * @param \Magento\Framework\Registry $coreRegistry
	 * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender
	 * @param \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender
	 * @param \Magento\Checkout\Model\Session $checkoutSession
	 * @param \Customweb\OPPCw\Model\DependencyContainer $container
	 * @param \Customweb\OPPCw\Model\Alias\Handler $aliasHandler
	 * @param \Customweb\OPPCw\Model\Authorization\TransactionContextFactory $transactionContextFactory
	 * @param \Customweb\OPPCw\Model\Authorization\TransactionFactory $transactionFactory
	 * @param \Customweb\OPPCw\Model\ResourceModel\Authorization\Transaction\CollectionFactory $transactionCollectionFactory
	 * @param \Customweb\OPPCw\Model\Authorization\Method\Context\Factory $contextFactory
	 * @param \Customweb\OPPCw\Model\Authorization\Method\Context\IContext $context
	 */
	public function __construct(
			\Psr\Log\LoggerInterface $logger,
			\Magento\Framework\Registry $coreRegistry,
			\Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
			\Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender,
			\Magento\Checkout\Model\Session $checkoutSession,
			\Customweb\OPPCw\Model\DependencyContainer $container,
			\Customweb\OPPCw\Model\Alias\Handler $aliasHandler,
			\Customweb\OPPCw\Model\Authorization\TransactionContextFactory $transactionContextFactory,
			\Customweb\OPPCw\Model\Authorization\TransactionFactory $transactionFactory,
			\Customweb\OPPCw\Model\ResourceModel\Authorization\Transaction\CollectionFactory $transactionCollectionFactory,
			\Customweb\OPPCw\Model\Authorization\Method\Context\Factory $contextFactory,
			\Customweb\OPPCw\Model\Authorization\Method\Context\IContext $context


	) {
		$this->_logger = $logger;
		$this->_coreRegistry = $coreRegistry;
		$this->_orderSender = $orderSender;
		$this->_invoiceSender = $invoiceSender;
		$this->_checkoutSession= $checkoutSession;
		$this->_container = $container;
		$this->_aliasHandler = $aliasHandler;
		$this->_transactionContextFactory = $transactionContextFactory;
		$this->_transactionFactory = $transactionFactory;
		$this->_transactionCollectionFactory = $transactionCollectionFactory;
		$this->_contextFactory = $contextFactory;
		$this->context = $context;

	}

	/**
	 * @return \Customweb\OPPCw\Model\Authorization\Method\Context\IContext
	 */
	public function getContext()
	{
		if (!($this->context instanceof \Customweb\OPPCw\Model\Authorization\Method\Context\IContext)) {
			throw new \Exception("No context has been set.");
		}
		return $this->context;
	}

	/**
	 * @param \Customweb\OPPCw\Model\Authorization\Method\Context\IContext $context
	 */
	public function setContext(\Customweb\OPPCw\Model\Authorization\Method\Context\IContext $context)
	{
		$this->context = $context;
	}

	/**
	 * @return \Customweb_Payment_Authorization_IAdapter
	 */
	public function getAdapter()
	{
		if (!($this->interfaceAdapter instanceof \Customweb_Payment_Authorization_IAdapter)) {
			$this->interfaceAdapter = $this->_container->getBean($this->getAdapterInterfaceName());
		}
		return $this->interfaceAdapter;
	}

	public function initializeTransaction(\Customweb\OPPCw\Model\Authorization\Transaction $transaction)
	{
		$transaction->setAliasActive($this->getContext()->getOrderContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('alias_manager') == 'active');

		$transactionContext = $this->_transactionContextFactory->create([
			'transaction' => $transaction,
			'orderContext' => $this->getContext()->getOrderContext(),
			'orderId' => $this->getContext()->getOrder()->getIncrementId(),
			'aliasTransactionId' => $this->getContext()->getAliasTransaction()
		]);
		$this->_checkoutSession->unsOPPCwCheckoutId();

		$transactionObject = $this->getAdapter()->createTransaction($transactionContext, null);
		$transaction->setTransactionObject($transactionObject);
		$transaction->save();

		$this->context = $this->_contextFactory->createTransaction($transaction);
	}

	/**
	 * @return array
	 */
	public function startAuthorization()
	{
		return [
			'formActionUrl' => $this->getFormActionUrl(),
			'hiddenFormFields' => $this->getHiddenFormFields()
		];
	}

	/**
	 * @param \Customweb\OPPCw\Model\Authorization\Transaction $transaction
	 */
	public function finishAuthorization()
	{
		if ($this->getContext()->getTransaction()->getTransactionObject()->isAuthorized()) {
			if ($this->getContext()->getPaymentMethod() instanceof \Customweb\OPPCw\Model\Payment\Method\AbstractMethod) {
				$this->_coreRegistry->register('oppcw_authorization_transaction', $this->getContext()->getTransaction());
				$payment = $this->getContext()->getTransaction()->getOrderPayment();
				$payment->setTransactionId($this->getContext()->getTransaction()->getTransactionObject()->getPaymentId());
				if (is_array($this->getContext()->getTransaction()->getTransactionObject()->getTransactionData())) {
					foreach ($this->getContext()->getTransaction()->getTransactionObject()->getTransactionData() as $key => $value) {
						$payment->setTransactionAdditionalInfo($key, $value);
					}
				}
				if ($this->getContext()->getTransaction()->getTransactionObject()->isCaptured()) {
					$payment->registerCaptureNotification($this->getContext()->getOrder()->getGrandTotal(), true);
					if ($payment->getCreatedInvoice()) {
						$invoice = $payment->getCreatedInvoice();
					} else {
						$invoice = $this->getInvoiceByTransactionId($payment->getOrder(), $payment->getTransactionId());
					}
				} else {
					$payment->authorize(true, $this->getContext()->getOrder()->getGrandTotal());
					$invoice = $this->createInvoice();
				}
				$this->getContext()->getOrder()->save();
				if ($this->getContext()->getTransaction()->isSendEmail()) {
					try {
						$this->_orderSender->send($this->getContext()->getOrder());
						if ($invoice instanceof \Magento\Sales\Model\Order\Invoice) {
							$this->sendInvoiceEmail($invoice);
						}
					} catch (\Exception $e) {
						$this->_logger->critical($e);
					}
				}
			}
		} elseif ($this->getContext()->getTransaction()->getTransactionObject()->isAuthorizationFailed()) {
			$this->getContext()->getOrder()->cancel()->save();
		}
	}

	/**
	 * @return string
	 */
	public function getFormActionUrl()
	{
		if (method_exists($this->getAdapter(), 'getFormActionUrl')) {
			$result = $this->getAdapter()->getFormActionUrl($this->getContext()->getTransaction()->getTransactionObject());
			$this->getContext()->getTransaction()->save();
			return $result;
		} else {
			return '';
		}
	}

	/**
	 * @return Customweb_Form_IElement[]
	 */
	public function getVisibleFormFields()
	{
		$formFields = [];
		if ($this->getContext()->getOrderContext()->isValid()) {
			$aliasFormField = $this->getAliasFormField();
			if ($aliasFormField instanceof \Customweb_Form_IElement) {
				$formFields[] = $aliasFormField;
			}
			if (method_exists($this->getAdapter(), 'getVisibleFormFields')) {
				$formFields = array_merge($formFields, $this->getAdapter()->getVisibleFormFields(
						$this->getContext()->getOrderContext(),
						$this->getAliasTransaction() == null ? null : $this->getAliasTransaction()->getTransactionObject(),
						null,
						$this->getContext()->getCustomerContext()
				));
				$this->getContext()->getCustomerContext()->save();
			}
		}
		return $formFields;
	}

	/**
	 * @return array
	 */
	public function getHiddenFormFields()
	{
		if (method_exists($this->getAdapter(), 'getHiddenFormFields')) {
			$result = $this->getAdapter()->getHiddenFormFields($this->getContext()->getTransaction()->getTransactionObject());
			$this->getContext()->getTransaction()->save();
			return $result;
		} else {
			return '';
		}
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function preValidate()
	{
		if ($this->getContext()->getOrderContext()->isValid()) {
			try {
				$this->getAdapter()->preValidate($this->getContext()->getOrderContext(), $this->getContext()->getCustomerContext());
			} catch (\Exception $e) {
				$this->getContext()->getCustomerContext()->save();
				throw $e;
			}
		}
		$this->getContext()->getCustomerContext()->save();
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function validate()
	{
		try {
			$this->getAdapter()->validate($this->getContext()->getOrderContext(), $this->getContext()->getCustomerContext(), $this->getContext()->getParameters());
		} catch (\Exception $e) {
			$this->getContext()->getCustomerContext()->save();
			throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()), $e);
		}
		$this->getContext()->getCustomerContext()->save();
	}

	/**
	 * @return Customweb_Form_IElement
	 */
	protected function getAliasFormField()
	{
		
		if ($this->getContext()->getOrderContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('alias_manager') != 'active') {
			return null;
		}

		$checkboxControl = new \Customweb_Form_Control_SingleCheckbox('alias[create]', '1', __('Store the payment details'));

		$aliasTransactions = $this->_aliasHandler->getAliasTransactions($this->getContext()->getOrderContext());
		if (is_array($aliasTransactions) && !empty($aliasTransactions)) {
			$options = ['' => ''];
			foreach ($aliasTransactions as $transaction) {
				$options[$transaction->getId()] = $transaction->getAliasForDisplay();
			}
			$selectControl = new \Customweb_Form_Control_Select('alias[select]', $options, $this->getContext()->getAliasTransaction());

			$aliasTransaction = $this->getContext()->getAliasTransaction();
			if (empty($aliasTransaction)) {
				$control = new \Customweb_Form_Control_MultiControl('alias', [$checkboxControl, $selectControl]);
			} else {
				$control = $selectControl;
			}
			$aliasElement = new \Customweb_Form_Element(__('Stored payment details'), $control, __('You may choose one of your stored payment details.'));
		} else {
			$aliasElement = new \Customweb_Form_Element(__('Stored payment details'), $checkboxControl);
		}
		$aliasElement->setRequired(false);
		$aliasElement->setElementIntention(new \Customweb_Form_Intention_Intention('alias'));
		return $aliasElement;
		
	}

	/**
	 * @return \Customweb\OPPCw\Model\Authorization\Transaction|null
	 */
	protected function getAliasTransaction()
	{
		if ($this->getContext()->getAliasTransaction() != null && $this->getContext()->getAliasTransaction() != 'new') {
			$aliasTransaction = $this->_transactionFactory->create()->load($this->getContext()->getAliasTransaction());
			if ($aliasTransaction->getId()) {
				return $aliasTransaction;
			}
		}
		return null;
	}

	/**
	 * @return \Magento\Sales\Model\Order\Invoice
	 */
	private function createInvoice()
	{
		if ($this->getContext()->getPaymentMethod() instanceof \Customweb\OPPCw\Model\Payment\Method\AbstractMethod) {
			$payment = $this->getContext()->getTransaction()->getOrderPayment();
			if ($this->getContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('settlement') == 'direct') {
				$order = $this->getContext()->getOrder();
				if (!$order->hasInvoices()) {
					$invoice = $order->prepareInvoice();
					$invoice->register();
					$invoice->setTransactionId($payment->getTransactionId());
					$order->addRelatedObject($invoice);
					return $invoice;
				}
			}
		}
	}

	/**
	 * @param \Magento\Sales\Api\Data\OrderInterface $order
	 * @param string $transactionId
	 * @return \Magento\Sales\Model\Order\Invoice
	 */
	private function getInvoiceByTransactionId(\Magento\Sales\Api\Data\OrderInterface $order, $transactionId) {
		foreach ($order->getInvoiceCollection() as $invoice) {
			if ($invoice->getTransactionId() == $transactionId) {
				$invoice->load($invoice->getId());
				// to make sure all data will properly load (maybe not required)
				return $invoice;
			}
		}
		foreach ($order->getInvoiceCollection() as $invoice) {
			if ($invoice->getState() == \Magento\Sales\Model\Order\Invoice::STATE_OPEN
				&& $invoice->load($invoice->getId())) {
				$invoice->setTransactionId($transactionId);
				return $invoice;
			}
		}
	}

	private function sendInvoiceEmail(\Magento\Sales\Model\Order\Invoice $invoice)
	{
		if ($this->getContext()->getPaymentMethod() instanceof \Customweb\OPPCw\Model\Payment\Method\AbstractMethod) {
			if ($this->getContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('invoice_email')) {
				$this->_invoiceSender->send($invoice);
			}
		}
	}

	/**
	 * Retrieve the interface name of the adapter.
	 *
	 * @return string
	 */
	abstract protected function getAdapterInterfaceName();
}