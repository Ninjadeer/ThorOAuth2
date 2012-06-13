<?php
namespace ThorOAuth2\Service;

use ThorOAuth2\Options\AuthorizationRequest;

use ThorOAuth2\Model\AuthCode;

use ThorOAuth2\Model\ClientMapper;

use
ThorOAuth2\Form\ClientFilter,
ZfcBase\EventManager\EventProvider;

class ServerService extends EventProvider
{
	protected $clientMapper;
	protected $authCodeMapper;

	protected $clientFilterForm;

	public function fetchClient() {
	}

	public function findClientById($clientId) {
		// @todo filter values
		return $this->clientMapper->findById($clientId);
	}

	/**
	 * @param AuthorizationRequest $authorizationRequest
	 */
	public function generateAuthCode(AuthorizationRequest $authorizationRequest) {
		$AuthCode = new AuthCode();
		$AuthCode->setCode($this->genToken());
		$AuthCode->setClientId($authorizationRequest->getClientId());
		$AuthCode->setRedirectUri($authorizationRequest->getRedirectUri());
		$AuthCode->setExpires(time()+600); //@todo This is currently hard set to 10 mins as per recommendation
		$AuthCode->setScope($authorizationRequest->getScope());

		return $this->authCodeMapper->insert($AuthCode);
	}

	/**
	 * @todo This is borrowed from https://github.com/FriendsOfSymfony/oauth2-php/blob/master/lib/OAuth2/OAuth2.php 1190 I should rewrite it
	 */
	public function genToken() {
		if (function_exists('openssl_random_pseudo_bytes') && 0 !== stripos(PHP_OS, 'win')) {
			$bytes = openssl_random_pseudo_bytes(32, $strong);

			if (true === $strong && false !== $bytes) {
				return rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
			}
		}

		if (file_exists('/dev/urandom')) { // Get 100 bytes of random data
			$randomData = file_get_contents('/dev/urandom', false, null, 0, 100).uniqid(mt_rand(), true);
		} else {
			$randomData = mt_rand().mt_rand().mt_rand().mt_rand().microtime(true).uniqid(mt_rand(), true);
		}
		return rtrim(strtr(base64_encode(hash('sha256', $randomData)), '+/', '-_'), '=');
	}

	/**
	 * @return ClientFilter
	 */
	public function getClientForm()
	{
	    return $this->clientForm;
	}

	/**
	 * @param ClientFilter $clientForm
	 */
	public function setClientForm(ClientFilter $clientForm)
	{
	    $this->clientForm = $clientForm;
	}

	/**
	 * @return ClientMapper
	 */
	public function getClientMapper()
	{
	    return $this->clientMapper;
	}

	/**
	 * @param ClientMapper $clientMapper
	 */
	public function setClientMapper(ClientMapper $clientMapper)
	{
	    $this->clientMapper = $clientMapper;
	}

	public function getClientFilterForm()
	{
	    return $this->clientFilterForm;
	}

	public function setClientFilterForm($clientFilterForm)
	{
	    $this->clientFilterForm = $clientFilterForm;
	}

	public function getAuthCodeMapper()
	{
	    return $this->authCodeMapper;
	}

	public function setAuthCodeMapper($codeMapper)
	{
	    $this->authCodeMapper = $codeMapper;
	}
}