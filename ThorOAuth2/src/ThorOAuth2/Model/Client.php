<?php

namespace ThorOAuth2\Model;

use DateTime,
    ZfcBase\Model\ModelAbstract;

class Client extends ModelAbstract implements ClientInterface
{

	protected $client_id;

	protected $client_secret;

	protected $redirect_uri;

	public function getClientId()
	{
	    return $this->client_id;
	}

	public function setClientId($client_id)
	{
	    $this->client_id = $client_id;
	}

	public function getClientSecret()
	{
	    return $this->client_secret;
	}

	public function setClientSecret($client_secret)
	{
	    $this->client_secret = $client_secret;
	}

	public function getRedirectUri()
	{
	    return $this->redirect_uri;
	}

	public function setRedirectUri($redirect_uri)
	{
	    $this->redirect_uri = $redirect_uri;
	}
}
