<?php

namespace ThorOAuth2\Model;

use DateTime,
    ZfcBase\Model\ModelAbstract;

class AuthCode extends ModelAbstract implements AuthCodeInterface
{
	protected $code;
	protected $client_id;
	protected $user_id;
	protected $redirect_uri;
	protected $expires;
	protected $scope;

	public function getCode()
	{
	    return $this->code;
	}

	public function setCode($code)
	{
	    $this->code = $code;
	}

	public function getClientId()
	{
	    return $this->client_id;
	}

	public function setClientId($client_id)
	{
	    $this->client_id = $client_id;
	}

	public function getUserId()
	{
	    return $this->user_id;
	}

	public function setUserId($user_id)
	{
	    $this->user_id = $user_id;
	}

	public function getRedirectUri()
	{
	    return $this->redirect_uri;
	}

	public function setRedirectUri($redirect_uri)
	{
	    $this->redirect_uri = $redirect_uri;
	}

	public function getExpires()
	{
	    return $this->expires;
	}

	public function setExpires($expires)
	{
	    $this->expires = $expires;
	}

	public function getScope()
	{
	    return $this->scope;
	}

	public function setScope($scope)
	{
	    $this->scope = $scope;
	}
}
