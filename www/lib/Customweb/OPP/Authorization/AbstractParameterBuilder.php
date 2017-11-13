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
 */

//require_once 'Customweb/Payment/Authorization/Recurring/ITransactionContext.php';
//require_once 'Customweb/Util/Currency.php';
//require_once 'Customweb/Core/Util/System.php';
//require_once 'Customweb/OPP/AbstractParameterBuilder.php';
//require_once 'Customweb/Filter/Input/String.php';
//require_once 'Customweb/Core/Util/Rand.php';


abstract class Customweb_OPP_Authorization_AbstractParameterBuilder extends Customweb_OPP_AbstractParameterBuilder
{
	/**
	 * @param array $formData
	 * @return array
	 */
	public function buildAuthorizationParameters(array $formData = array())
	{
		return array_merge(
				$this->getAuthenticationParameters(),
				$this->getAdditionalParameters(),
				$this->getTestModeParameters(),
				$this->getBasicPaymentParameters(),
				$this->getCustomerParameters(),
				$this->getBillingAddressParameters(),
				$this->getShippingAddressParameters(),
				$this->getCartParameters(),
				$this->getTokenizationParameters(),
				$this->getRecurringParameters(),
				$this->getPaymentMethod()->getAuthorizationParameters($this->getTransaction(), $formData)
		);
	}

	/**
	 * @param array $formData
	 * @return array
	 */
	public function buildAliasAuthorizationParameters(array $formData = array())
	{
		return array_merge(
				$this->getAuthenticationParameters(),
				$this->getAdditionalParameters(),
				$this->getTestModeParameters(),
				$this->getBasicPaymentParameters(),
				$this->getCustomerParameters(),
				$this->getBillingAddressParameters(),
				$this->getShippingAddressParameters(),
				$this->getCartParameters(),
				$this->getPaymentMethod()->getAuthorizationParameters($this->getTransaction(), $formData),
				$this->getAsynchronousPaymentParameters()
		);
	}

	/**
	 * @return array
	 */
	public function buildStatusParameters()
	{
		return array_merge(
				$this->getAuthenticationParameters()
		);
	}

	/**
	 * @return array
	 */
	protected function getBasicPaymentParameters()
	{
		$parameters = array();
		$parameters['amount']					= Customweb_Util_Currency::formatAmount($this->getOrderContext()->getOrderAmountInDecimals(), $this->getOrderContext()->getCurrencyCode());
		$parameters['currency']					= $this->getOrderContext()->getCurrencyCode();
		$parameters['paymentType']				= $this->getPaymentMethod()->getPaymentTypeCode($this->getTransactionContext()->getCapturingMode());

		return $parameters;
	}

	/**
	 * @return array
	 */
	protected function getCustomerParameters()
	{
		$paymentCustomerContext = $this->getPaymentCustomerContext()->getMap();
		$parameters = array();
		if ($this->getOrderContext()->getCustomerId()) {
			$parameters['customer.merchantCustomerId']	= $this->getOrderContext()->getCustomerId();
		}
		else{
			$parameters['customer.merchantCustomerId']	= Customweb_Core_Util_Rand::getRandomString(64, '');
		}

		$parameters['customer.givenName']			= Customweb_Filter_Input_String::_($this->getOrderContext()->getBillingAddress()->getFirstName(), 48)->filter();
		$parameters['customer.surname']				= Customweb_Filter_Input_String::_($this->getOrderContext()->getBillingAddress()->getLastName(), 48)->filter();
		if ($this->getOrderContext()->getBillingAddress()->getGender() == 'male') {
			$parameters['customer.sex']				= 'M';
		} else if ($this->getOrderContext()->getBillingAddress()->getGender() == 'female') {
			$parameters['customer.sex']				= 'F';
		}
		if ($this->getOrderContext()->getBillingAddress()->getDateOfBirth()) {
			$parameters['customer.birthDate']		= $this->getOrderContext()->getBillingAddress()->getDateOfBirth()->format('Y-m-d');
		}
		if ($this->getOrderContext()->getBillingAddress()->getPhoneNumber()) {
			$parameters['customer.phone']			= Customweb_Filter_Input_String::_($this->getOrderContext()->getBillingAddress()->getPhoneNumber(), 25)->filter();
		}
		if ($this->getOrderContext()->getBillingAddress()->getMobilePhoneNumber()) {
			$parameters['customer.mobile']			= Customweb_Filter_Input_String::_($this->getOrderContext()->getBillingAddress()->getMobilePhoneNumber(), 25)->filter();
		}
		$parameters['customer.email']				= Customweb_Filter_Input_String::_($this->getOrderContext()->getCustomerEMailAddress(), 128)->filter();
		if ($this->getOrderContext()->getBillingAddress()->getCompanyName()) {
			$parameters['customer.companyName']		= Customweb_Filter_Input_String::_($this->getOrderContext()->getBillingAddress()->getCompanyName(), 40)->filter();
		}
		try {
			$parameters['customer.ip']					= Customweb_Core_Util_System::getClientIPAddress();
		} catch (Exception $e) {}
		return $parameters;
	}

	/**
	 * @return array
	 */
	protected function getBillingAddressParameters()
	{
		$parameters = array();
		$billing = $this->getOrderContext()->getBillingAddress();

		$parameters['billing.street1']		= Customweb_Filter_Input_String::_(trim($billing->getStreet()), 50)->filter();
		$parameters['billing.city']			= Customweb_Filter_Input_String::_(trim($billing->getCity()), 30)->filter();
		$state = trim($billing->getState());
		if (!empty($state)) {
			if(strlen($state) < 2){
				if(is_int($state)) {
					$state = '0'.$state;
				}
				else{
					$state = ' '.$state;
				}
			}
			$parameters['billing.state']	= Customweb_Filter_Input_String::_($state, 50)->filter();
		}
		$parameters['billing.postcode']		= Customweb_Filter_Input_String::_(trim($billing->getPostCode()), 10)->filter();
		$parameters['billing.country']		= $billing->getCountryIsoCode();

		return $parameters;
	}

	/**
	 * @return array
	 */
	protected function getShippingAddressParameters()
	{
		$parameters = array();
		$shipping = $this->getOrderContext()->getShippingAddress();

		$parameters['shipping.givenName']	= Customweb_Filter_Input_String::_(trim($shipping->getFirstName()), 48)->filter();
		$parameters['shipping.surname']		= Customweb_Filter_Input_String::_(trim($shipping->getLastName()), 48)->filter();
		$parameters['shipping.street1']		= Customweb_Filter_Input_String::_(trim($shipping->getStreet()), 50)->filter();
		$parameters['shipping.city']		= Customweb_Filter_Input_String::_(trim($shipping->getCity()), 30)->filter();
		$state = trim($shipping->getState());
		if (!empty($state)) {
			if(strlen($state) < 2){
				if(is_int($state)) {
					$state = '0'.$state;
				}
				else{
					$state = ' '.$state;
				}
			}
			$parameters['shipping.state']	= Customweb_Filter_Input_String::_($state, 50)->filter();
		}
		$parameters['shipping.postcode']	= Customweb_Filter_Input_String::_(trim($shipping->getPostCode()), 10)->filter();
		$parameters['shipping.country']		= $shipping->getCountryIsoCode();

		return $parameters;
	}

	/**
	 * @return array
	 */
	protected function getCartParameters()
	{
		return $this->getPaymentMethod()->getCartItemParameters($this->getTransaction());
	}

	/**
	 * @return array
	 */
	protected function getTokenizationParameters()
	{
		$parameters = array();
		if ($this->getTransactionContext()->getAlias() == 'new' && !in_array('AliasManager', $this->getPaymentMethod()->getNotSupportedFeatures())) {
			$parameters['createRegistration'] = 'true';
		}
		return $parameters;
	}

	/**
	 * @return array
	 */
	protected function getRecurringParameters()
	{
		$parameters = array();
		if ($this->getTransactionContext() instanceof Customweb_Payment_Authorization_Recurring_ITransactionContext
				&& $this->getTransactionContext()->createRecurringAlias()) {
			$parameters['recurringType'] = 'INITIAL';
			$parameters['createRegistration'] = 'true';
		}
		return $parameters;
	}

	/**
	 * @return array
	 */
	protected function getAsynchronousPaymentParameters()
	{
		$parameters = array();
		$parameters['shopperResultUrl'] = (string) $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter')->getUrl('process', 'async', array(
												'cw_transaction_id' => $this->getTransaction()->getExternalTransactionId()
											));
		return $parameters;
	}
}
