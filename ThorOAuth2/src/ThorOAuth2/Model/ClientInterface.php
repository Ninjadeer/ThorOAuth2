<?php

namespace ThorOAuth2\Model;

interface ClientInterface
{
	/**
     * Get clientId.
     *
     * @return string clientId
     */
	public function getClientId();

	/**
	 * Set client_id
	 *
	 * @param string $client_id
	 */
	public function setClientId($client_id);

	/**
	 * Get clientSecret
	 *
	 * @return string clientSecret
	 */
	public function getClientSecret();

	/**
	 * Set Client Secret
	 *
	 * @param string $client_secret
	 */
	public function setClientSecret($client_secret);


	/**
	 * Get redirectUri
	 *
	 * @return string clientSecret
	 */
	public function getRedirectUri();


	/**
	 * Set redirectUri Secret
	 *
	 * @param string $client_secret
	 */
	public function setRedirectUri($redirect_uri);
}
