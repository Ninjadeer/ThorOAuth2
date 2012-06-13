<?php

namespace ThorOAuth2\Controller;

use ThorOAuth2\Options\AuthorizationRequest;

use Zend\Http\Request;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
	ThorOAuth2\Controller\Plugin\AuthorizationError;

class AuthorizationController extends ActionController
{
    /**
     * This Action provides authorization according 1.2 of http://tools.ietf.org/html/draft-ietf-oauth-v2-27
     *
     * (C)  The client requests an access token by authenticating with the
     * 		authorization server and presenting the authorization grant.
     * (D)  The authorization server authenticates the client and validates
     * 		the authorization grant, and if valid issues an access token.
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function requestAction()
    {
    	$authorizationResponse = $this->authorizationServer()->handle($this->getRequest());

		return false;
    }

    public function errorAction() {

    }
}
