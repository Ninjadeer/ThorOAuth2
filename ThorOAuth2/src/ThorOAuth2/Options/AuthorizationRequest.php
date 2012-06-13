<?php

/**
 * This class models the request for the OAuth 2.0 specification acording to 4.1.1
 * @author balchc
 */

namespace ThorOAuth2\Options;

use ZfcBase\Model\ModelAbstract;

class AuthorizationRequest extends ModelAbstract {

	const REQUEST_TYPE_TOKEN = 'token';
	const REQUEST_TYPE_CODE = 'code';

	/**
	 * REQUIRED.  Value MUST be set to "code".
	 * @var string
	 */
	protected $response_type;

	/**
	 * REQUIRED.  The client identifier as described in Section 2.2.
	 * @var string
	 */
	protected $client_id;

	/**
	 * OPTIONAL.  As described in Section 3.1.2.
	 * @var string
	 */
	protected $redirect_uri;

	/**
	 *  OPTIONAL.  The scope of the access request as described by
	 *  Section 3.3.
	 * @var string
	 */
	protected $scope;

	/**
	 * RECOMMENDED.  An opaque value used by the client to maintain
	 * state between the request and callback.  The authorization
	 * server includes this value when redirecting the user-agent back
	 * to the client.  The parameter SHOULD be used for preventing
	 * cross-site request forgery as described in Section 10.12.
	 * @var string
	 */
	protected $state;

	public function getResponseType()
	{
	    return $this->response_type;
	}

	public function setResponseType($response_type)
	{
	    $this->response_type = $response_type;
	}

	public function getClientId()
	{
	    return $this->client_id;
	}

	public function setClientId($client_id)
	{
	    $this->client_id = $client_id;
	}

	public function getRedirectUri()
	{
	    return $this->redirect_uri;
	}

	public function setRedirectUri($redirect_uri)
	{
	    $this->redirect_uri = $redirect_uri;
	}

	public function getScope()
	{
	    return $this->scope;
	}

	public function setScope($scope)
	{
	    $this->scope = $scope;
	}

	public function getState()
	{
	    return $this->state;
	}

	public function setState($state)
	{
	    $this->state = $state;
	}
}