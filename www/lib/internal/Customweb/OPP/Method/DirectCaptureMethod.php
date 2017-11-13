<?php

/**
 *  * You are allowed to use this API in your web application.
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
 * @Method(paymentMethods={'Trustpay', 'Trustly', 'Alipay', 'Przelewy24', 'Tenpay', 'Daopay', 'CashU', 'Entercash', 'Yandex', 'OneCard'})
 */
class Customweb_OPP_Method_DirectCaptureMethod extends Customweb_OPP_Method_DefaultMethod {

	public function getPaymentTypeCode($capturingMode = null){
		return Customweb_OPP_IConstants::PAYMENT_TYPE_DEBIT;
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @param stdClass $response
	 * @return boolean
	 */
	protected function validatePaymentType(Customweb_Payment_Authorization_ITransaction $transaction, $response){
		if (!isset($response->paymentType)) {
			return false;
		}
		if ($response->paymentType == 'DB' || $response->paymentType == 'RC') {
			return true;
		}
		return false;
	}
}