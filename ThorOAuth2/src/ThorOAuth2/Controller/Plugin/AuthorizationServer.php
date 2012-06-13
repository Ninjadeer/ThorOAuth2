<?php

/**
 * This class models the Error Response for the OAuth 2.0
 * http://tools.ietf.org/html/draft-ietf-oauth-v2-27#section-4.1.2.1
 *  *
 * @author balchc
 */

namespace ThorOAuth2\Controller\Plugin;

use Zend\Date\Date;

use Zend\Filter\Encrypt\Openssl;

use ThorOAuth2\Options\AuthorizationResponse;

use ThorOAuth2\Service\ServerService;

use Zend\Http\PhpEnvironment\Request;

use Zend\Mvc\Router\Http\Method;

use ThorOAuth2\Options\AuthorizationRequest;

use Zend\Uri\Http;

use Zend\Mvc\Controller\Plugin\Redirect;

class AuthorizationServer extends Redirect {

	/**
	 * @var ServerService
	 */
	protected $serverService;

	public function handle(Request $request) {

		$authorizationRequest = new AuthorizationRequest();
		$authorizationRequest->populate($request->query()->toArray());

		// Create response
		$authorizationResponse = new AuthorizationResponse();

		/*
		 * 10.12. Cross-Site Request Forgery
		 *
		 * Cross-site request forgery (CSRF) is an exploit in which an attacker
		 * causes the user-agent of a victim end-user to follow a malicious URI
		 * (e.g. provided to the user-agent as a misleading link, image, or
		 * redirection) to a trusting server (usually established via the
		 * presence of a valid session cookie).

		 * A CSRF attack against the client's redirection URI allows an attacker
		 * to inject their own authorization code or access token, which can
		 * result in the client using an access token associated with the
		 * attacker's protected resources rather than the victim's (e.g. save
		 * the victim's bank account information to a protected resource
		 * controlled by the attacker).

		 * The client MUST implement CSRF protection for its redirection URI.
		 * This is typically accomplished by requiring any request sent to the
		 * redirection URI endpoint to include a value that binds the request to
		 * the user-agent's authenticated state (e.g. a hash of the session
		 * cookie used to authenticate the user-agent).  The client SHOULD
		 */
		$authorizationResponse->setState($authorizationRequest->getState());

		/*
		 * The authorization server MUST support the use of the HTTP "GET"
		 * method [RFC2616] for the authorization endpoint, and MAY support the
		 * use of the "POST" method as well.
		 *
		 * @todo Make Post method optional via config
		 * @todo Determined the default response when a client is not loaded
		 */
		if ($request->getMethod() != Request::METHOD_GET && $request->getMethod() != Request::METHOD_POST) {
			$authorizationResponse->setError(AuthorizationResponse::INVALID_REQUEST);
			return $this->sendResponse($authorizationResponse, $authorizationRequest);
		}

		/* response_type is REQUIRED
		 * http://tools.ietf.org/html/draft-ietf-oauth-v2-27#section-3.1.1
		 */
		if ($authorizationRequest->getResponseType() == '') {
			$authorizationResponse->setError(AuthorizationResponse::UNSUPPORTED_RESPONSE_TYPE);
			return $this->sendResponse($authorizationResponse, $authorizationRequest);
		}

		/*
		 *
		 * 2.2. Client Identifier
		 *
		 * The authorization server issues the registered client a client
		 * identifier - a unique string representing the registration
		 * information provided by the client.  The client identifier is not a
		 * secret; it is exposed to the resource owner, and MUST NOT be used
		 * alone for client authentication.  The client identifier is unique to
		 * the authorization server.
		 *
		 * The client identifier string size is left undefined by this
		 * specification.  The client should avoid making assumptions about the
		 * identifier size.  The authorization server SHOULD document the size
		 * of any identifier it issues.
		 */
		if ($authorizationRequest->getClientId() == '') {
			$authorizationResponse->setError(AuthorizationResponse::INVALID_REQUEST);
			return $this->sendResponse($authorizationResponse, $authorizationRequest);
		}

		$clientModel = $this->serverService->findClientById($authorizationRequest->getClientId());

		if (!$clientModel) {
			$authorizationResponse->setError(AuthorizationResponse::UNAUTHORIZED_CLIENT);
			return $this->sendResponse($authorizationResponse, $authorizationRequest);
		}

		/*
		 * 10.6. Authorization Code Redirection URI Manipulation
		 *
		 * When requesting authorization using the authorization code grant
		 * type, the client can specify a redirection URI via the "redirect_uri"
		 * parameter.  If an attacker can manipulate the value of the
		 * redirection URI, it can cause the authorization server to redirect
		 * the resource owner user-agent to a URI under the control of the
		 * attacker with the authorization code.
		 *
		 * An attacker can create an account at a legitimate client and initiate
		 * the authorization flow.  When the attacker's user-agent is sent to
		 * the authorization server to grant access, the attacker grabs the
		 * authorization URI provided by the legitimate client, and replaces the
		 * client's redirection URI with a URI under the control of the
		 * attacker.  The attacker then tricks the victim into following the
		 * manipulated link to authorize access to the legitimate client.
		 *
		 * Once at the authorization server, the victim is prompted with a
		 * normal, valid request on behalf of a legitimate and trusted client,
		 * and authorizes the request.  The victim is then redirected to an
		 * endpoint under the control of the attacker with the authorization
		 * code.  The attacker completes the authorization flow by sending the
		 * authorization code to the client using the original redirection URI
		 * provided by the client.  The client exchanges the authorization code
		 * with an access token and links it to the attacker's client account
		 * which can now gain access to the protected resources authorized by
		 * the victim (via the client).
		 *
		 * In order to prevent such an attack, the authorization server MUST
		 * ensure that the redirection URI used to obtain the authorization code
		 * is identical to the redirection URI provided when exchanging the
		 * authorization code for an access token.  The authorization server
		 * MUST require public clients and SHOULD require confidential clients
		 * to register their redirection URIs.  If a redirection URI is provided
		 * in the request, the authorization server MUST validate it against the
		 * registered value.
		 */

		if ('' != $authorizationRequest->getRedirectUri() && $authorizationRequest->getRedirectUri() != $clientModel->getRedirectUri()) {
			$authorizationResponse->setError(AuthorizationResponse::INVALID_REQUEST);
			$authorizationResponse->setErrorDescription('Paramater redirect_uri is does not match the expected redirect_uri for this client');
			return $this->sendResponse($authorizationResponse, $authorizationRequest);
		}

		if ($authorizationRequest->getResponseType() == 'code') {
			$authCodeModel = $this->serverService->generateAuthCode($authorizationRequest);
			$authorizationResponse->setCode($authCodeModel->getCode());
		} elseif($authorizationRequest->getResponseType() == 'token') {

		} else {
			// Do something in factory ?
		}

		return $this->sendResponse($authorizationResponse, $authorizationRequest);
	}

	public function sendResponse(AuthorizationResponse $authorizationResponse, $authorizationRequest) {
		$http = new Http();

		$http->parse($authorizationRequest->getRedirectUri());

		// @todo should we perserve queries ?
		$http->setQuery($authorizationResponse->toArray());

		parent::toUrl($http->toString());
	}

	/**
	 * @return ServerService
	 */
	public function getServerService()
	{
	    return $this->serverService;
	}

	/**
	 * @param ServerService $clientService
	 */
	public function setServerService(ServerService $serverService)
	{
	    $this->serverService = $serverService;
	}


}