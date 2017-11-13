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
 * @Controller("process")
 */
class Customweb_OPP_Endpoint_Process extends Customweb_Payment_Endpoint_Controller_Abstract {

	/**
	 * @var Customweb_Core_ILogger
	 */
	private $logger;
	
	/**
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		parent::__construct($container);
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class());
	}
	
	/**
	 *
	 * @Action("index")
	 */
	public function process(Customweb_Core_Http_IRequest $request){
		$idMap = $this->getTransactionId($request);
		$response = null;
		try {
			$this->getTransactionHandler()->beginTransaction();
			$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($idMap['id']);
			$this->logger->logInfo("The return process has been started for the transaction " . $transaction->getTransactionId() . ".");
			$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
			$parameters = $request->getParameters();
			$response = $adapter->processAuthorization($transaction, $parameters);
			$this->getTransactionHandler()->persistTransactionObject($transaction);
			$this->getTransactionHandler()->commitTransaction();
			$this->logger->logInfo("The return process has been finished for the transaction " . $transaction->getTransactionId() . ".");
			return $response;
		}
		catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
			$this->logger->logInfo("The return process has been rolledback for the transaction " . $idMap['id'] . ".");
			$this->getTransactionHandler()->rollbackTransaction();
			return $response;
		}
	}

	/**
	 *
	 * @Action("alias")
	 */
	public function processAlias(Customweb_Core_Http_IRequest $request){
		$idMap = $this->getTransactionId($request);
		$response = null;
		
		try {
			$this->getTransactionHandler()->beginTransaction();
			$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($idMap['id']);
			$this->logger->logInfo("The alias process has been started for the transaction " . $transaction->getTransactionId() . ".");
			$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
			$parameters = $request->getParameters();
			$response = $adapter->processAliasAuthorization($transaction, $parameters);
			$this->getTransactionHandler()->persistTransactionObject($transaction);
			$this->getTransactionHandler()->commitTransaction();
			$this->logger->logInfo("The alias process has been finished for the transaction " . $transaction->getTransactionId() . ".");
			return $response;
		}
		catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
			$this->logger->logInfo("The alias process has been rolledback for the transaction " . $idMap['id'] . ".");
			$this->getTransactionHandler()->rollbackTransaction();
			return $response;
		}
		
	}

	/**
	 *
	 * @Action("async")
	 */
	public function processAsync(Customweb_Core_Http_IRequest $request){
		$idMap = $this->getTransactionId($request);
		$response = null;
		
		try {
			$this->getTransactionHandler()->beginTransaction();
			$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($idMap['id']);
			$this->logger->logInfo("The async process has been started for the transaction " . $transaction->getTransactionId() . ".");
			$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
			$parameters = $request->getParameters();
			$response = $adapter->processAsynchronousAuthorization($transaction, $parameters);
			$this->getTransactionHandler()->persistTransactionObject($transaction);
			$this->getTransactionHandler()->commitTransaction();
			$this->logger->logInfo("The async process has been finished for the transaction " . $transaction->getTransactionId() . ".");
			return $response;
		}
		catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
			$this->getTransactionHandler()->rollbackTransaction();
			$this->logger->logInfo("The async process has been rolledback for the transaction " . $idMap['id'] . ".");
			return $response;
		}
	}

	/**
	 * @Action('webhook')
	 */
	public function processWebhook(Customweb_Core_Http_IRequest $request){
		$configuration = $this->getContainer()->getBean('Customweb_OPP_Configuration');
		$secretKey = trim($configuration->getConfigurationValue('webhook_secret_key'));
		$headers = array_change_key_case($request->getParsedHeaders(), CASE_LOWER);
		$errorMessage = '';
		$this->logger->logInfo("The webhook process has been started.");
		try {
			$initializationVector = $headers['x-initialization-vector'];
			$authenticationTag = $headers['x-authentication-tag'];
			$body = $request->getBody();
			
			$decrypted = Customweb_OPP_AESGCM::decrypt(hex2bin($secretKey), hex2bin($initializationVector), hex2bin($body), null, 
					hex2bin($authenticationTag));
			$decoded = json_decode($decrypted);
			
			if (!isset($decoded->payload->customParameters->cwExternalId) || !isset($decoded->type)) {
				$this->logger->logInfo("The webhook process could not decrypt the message.");
				return Customweb_Core_Http_Response::_("");
			}
			
			$externalTransactionId = $decoded->payload->customParameters->cwExternalId;
			$this->logger->logInfo("The webhook process has been started for the transaction with external id " . $externalTransactionId . ".");
			for ($i = 0; $i < 5; $i++) {
				try {
					$this->getTransactionHandler()->beginTransaction();
					$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($externalTransactionId);					
					if ($decoded->type == 'PAYMENT') {
						if (!isset($decoded->payload->paymentType) ||
								($decoded->payload->paymentType != 'PA' && $decoded->payload->paymentType != 'DB' && $decoded->payload->paymentType != 'RC')) {
							$this->getTransactionHandler()->commitTransaction();
							$paymentType = "Not Set";
							if(isset($decoded->payload->paymentType)){
								$paymentType  = (string) $decoded->payload->paymentType;
							}							
							$this->logger->logInfo("The webhook process has been finished for the transaction with external id " . $externalTransactionId . ". Unhandled Payment Type: ".$paymentType);
							return Customweb_Core_Http_Response::_("");
						}
						$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
						$adapter->finalizeAuthorization($transaction, $decoded->payload);
					}
					elseif ($decoded->type == 'REGISTRATION') {
						if (!isset($decoded->action) || $decoded->action != 'CREATED') {
							$this->getTransactionHandler()->commitTransaction();
							$action = "Not Set";
							if(isset($decoded->action)){
								$action  = (string) $decoded->action;
							}
							$this->logger->logInfo("The webhook process has been finished for the transaction with external id " . $externalTransactionId . ". Unhandled Registration Action: ".$action);
							return Customweb_Core_Http_Response::_("");
						}
						$transaction->setRegistrationId($decoded->payload->id);
						$transaction->registerAliasDisplay($decoded->payload);
					}
					else{
						$this->logger->logInfo("The webhook has been called with unkown type for the transaction with external id " . $externalTransactionId . ". Unhandled Type: ".$decoded->type);
					}
					$this->getTransactionHandler()->persistTransactionObject($transaction);
					$this->getTransactionHandler()->commitTransaction();
					$this->logger->logInfo("The webhook process has been finished for the transaction with external id " . $externalTransactionId . ".");
					return Customweb_Core_Http_Response::_("");
				}
				catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
					$this->getTransactionHandler()->rollbackTransaction();
					if($i == 4){
						throw $lockingException;
					}
					sleep(1);
				}
			}
		}
		catch (Exception $e) {
			$errorMessage = $e->getMessage();
			$this->logger->logException($e);
			return Customweb_Core_Http_Response::_($errorMessage)->setStatusCode(500);
		}		

	}
}