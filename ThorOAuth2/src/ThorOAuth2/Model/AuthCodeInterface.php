<?php

namespace ThorOAuth2\Model;

interface AuthCodeInterface
{
	public function getCode();

	public function setCode($code);

	public function getClientId();

	public function setClientId($client_id);

	public function getUserId();

	public function setUserId($user_id);

	public function getRedirectUri();

	public function setRedirectUri($redirect_uri);

	public function getExpires();

	public function setExpires($expires);

	public function getScope();

	public function setScope($scope);
}
