<?php

/**
 * This class models the Access Token Request for the OAuth 2.0 specification
 * http://tools.ietf.org/html/draft-ietf-oauth-v2-27#section-4.1.3
 * @author balchc
 *
 */

namespace ThorOAuth2\Model;

use ZfcBase\Model\ModelAbstract;

class TokenRequest extends ModelAbstract {

	/**
	 * REQUIRED.  Value MUST be set to "authorization_code".
	 * @var string
	 */
	public $grant_type;

	/**
	 * REQUIRED.  The authorization code received from the
	 * authorization server.
	 * @var string
	 */
	public $code;

	/**
	 * redirect_uri
	 * REQUIRED, if the "redirect_uri" parameter was included in the
	 * authorization request as described in Section 4.1.1, and their
	 * values MUST be identical.
	 * @var string
	 */
	public $redirect_uri;
}