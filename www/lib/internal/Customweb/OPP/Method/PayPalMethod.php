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



/**
 * @Method(paymentMethods={'PayPal'})
 */
class Customweb_OPP_Method_PayPalMethod extends Customweb_OPP_Method_DefaultMethod
{
	

	
	
	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext)
	{
		parent::preValidate($orderContext, $paymentContext);
		if ($orderContext->getShippingCountryIsoCode() == 'US' && $orderContext->getShippingState() == null) {
			throw new Exception(Customweb_I18n_Translation::__(
					"To use this payment method you need to add a state to your address.",
					array(
						'!paymentMethodName' => $this->getPaymentMethodDisplayName()
					)
			));
		}
		return true;
	}
	
	public function getCartItemParameters(Customweb_OPP_Authorization_OppTransaction $transaction){
		$parameters = array();
		
		$i = 0;
		$orderContext = $transaction->getTransactionContext()->getOrderContext();
		$itemTotalAmount = 0;
		foreach ($orderContext->getInvoiceItems() as $item) {
			
			if (round($item->getQuantity()) == 0) {
				continue;
			}
			
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$price = -1 * $item->getAmountIncludingTax() / round($item->getQuantity());
			}
			else {
				$price = $item->getAmountIncludingTax() / round($item->getQuantity());
			}
			
			if (Customweb_Util_Currency::compareAmount($price, 0, $orderContext->getCurrencyCode()) == 0) {
				continue;
			}
			
			$name = $item->getName();
			if (empty($name)) {
				$name = Customweb_I18n_Translation::__('No Name Provided');
			}
			
			$parameters['cart.items[' . $i . '].name'] = Customweb_Filter_Input_String::_($name, 255)->filter();
			$parameters['cart.items[' . $i . '].merchantItemId'] = Customweb_Filter_Input_String::_($item->getSku(), 255)->filter();
			$parameters['cart.items[' . $i . '].quantity'] = round($item->getQuantity());
			$parameters['cart.items[' . $i . '].type'] = 'physical';
			
			$itemTotalAmount += Customweb_Util_Currency::roundAmount($price, $orderContext->getCurrencyCode()) * round($item->getQuantity());
			$parameters['cart.items[' . $i . '].price'] = Customweb_Util_Currency::formatAmount($price, $orderContext->getCurrencyCode());
			$parameters['cart.items[' . $i . '].currency'] = $orderContext->getCurrencyCode();
			$parameters['cart.items[' . $i . '].tax'] = number_format($item->getTaxRate(), 1);
			$i++;
		}
		
		$expectedAmount = Customweb_Util_Currency::roundAmount($orderContext->getOrderAmountInDecimals(), $orderContext->getCurrencyCode());
		$diff = Customweb_Util_Currency::compareAmount($itemTotalAmount, $expectedAmount, $orderContext->getCurrencyCode());
		if ($diff > 0) {
			$parameters['cart.items[' . $i . '].name'] = Customweb_Filter_Input_String::_(Customweb_I18n_Translation::__("Rounding Adjustment")->toString(), 255)->filter();
			$parameters['cart.items[' . $i . '].merchantItemId'] = Customweb_Filter_Input_String::_('rounding-adjustment', 255)->filter();
			$parameters['cart.items[' . $i . '].quantity'] = 1;
			$parameters['cart.items[' . $i . '].type'] = 'physical';
			$parameters['cart.items[' . $i . '].price'] = Customweb_Util_Currency::formatAmount($expectedAmount - $itemTotalAmount, $orderContext->getCurrencyCode());
			$parameters['cart.items[' . $i . '].currency'] = $orderContext->getCurrencyCode();
			$parameters['cart.items[' . $i . '].tax'] = number_format(0, 1);
		} elseif ($diff < 0) {
			$parameters['cart.items[' . $i . '].name'] = Customweb_Filter_Input_String::_(Customweb_I18n_Translation::__("Rounding Adjustment")->toString(), 255)->filter();
			$parameters['cart.items[' . $i . '].merchantItemId'] = Customweb_Filter_Input_String::_('rounding-adjustment', 255)->filter();
			$parameters['cart.items[' . $i . '].quantity'] = 1;
			$parameters['cart.items[' . $i . '].type'] = 'physical';
			$parameters['cart.items[' . $i . '].price'] = Customweb_Util_Currency::formatAmount($itemTotalAmount - $expectedAmount, $orderContext->getCurrencyCode());
			$parameters['cart.items[' . $i . '].currency'] = $orderContext->getCurrencyCode();
			$parameters['cart.items[' . $i . '].tax'] = number_format(0, 1);
		}
		
		return $parameters;
	}
}