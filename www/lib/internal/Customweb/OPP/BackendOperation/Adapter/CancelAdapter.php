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
 * @Bean
 */
class Customweb_OPP_BackendOperation_Adapter_CancelAdapter extends Customweb_OPP_BackendOperation_Adapter_AbstractAdapter implements Customweb_Payment_BackendOperation_Adapter_Service_ICancel
{
	public function cancel(Customweb_Payment_Authorization_ITransaction $transaction)
	{
		

		$transaction->cancelDry();
		$response = $this->sendBackofficeRequest($transaction, $this->getParameterBuilder($transaction)->buildCancelParameters());
		if ($response->result->code != '000.000.000'
			&& $response->result->code != '000.600.000'
			&& strpos($response->result->code, '000.100.1') !== 0) {
			throw new Exception(Customweb_I18n_Translation::__($response->result->description));
		}
		$transaction->cancel(Customweb_I18n_Translation::__($response->result->description));
	}
}