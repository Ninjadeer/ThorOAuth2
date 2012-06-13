<?php

/**
 * This class models the Access Token Response for the OAuth 2.0 specification
 * http://tools.ietf.org/html/draft-ietf-oauth-v2-27#section-4.1.4
 * http://tools.ietf.org/html/draft-ietf-oauth-v2-27#section-5.1
 * @author balchc
 *
 */

namespace ThorOAuth2\Model;

use ZfcBase\Model\ModelAbstract;

class TokenRequest extends ModelAbstract {

	/**
	 * Client authentication failed (e.g. unknown client, no
	 * client authentication included, or unsupported
	 * authentication method).  The authorization server MAY
	 * return an HTTP 401 (Unauthorized) status code to indicate
	 * which HTTP authentication schemes are supported.  If the
	 * client attempted to authenticate via the "Authorization"
	 * request header field, the authorization server MUST
	 * respond with an HTTP 401 (Unauthorized) status code, and
	 * include the "WWW-Authenticate" response header field
	 * matching the authentication scheme used by the client.
	 * @var string
	 */
	const INVALID_CLIENT = 'invalid_client';

	/**
	 * The provided authorization grant (e.g. authorization
	 * code, resource owner credentials) or refresh token is
	 * invalid, expired, revoked, does not match the redirection
	 * URI used in the authorization request, or was issued to
	 * another client.
	 * @var string
	 */
	const INVALID_GRANT = 'invalid_grant';

	/**
	 * The authenticated client is not authorized to use this
	 * authorization grant type.
	 * @var string
	 */
	const UNAUTHORIZED_CLIENT = 'unauthorized_client';

	/**
	 * The authorization grant type is not supported by the
	 * authorization server.
	 * @var string
	 */
	const UNSUPPORTED_GRANT_TYPE = 'unsupported_grant_type';

	/**
	 * The requested scope is invalid, unknown, malformed, or
	 * exceeds the scope granted by the resource owner.
	 * @var string
	 */
	const INVALID_SCOPE = 'invalid_scope';

	protected $error_descriptions = array(
		self::INVALID_CLIENT => 'The request is missing a required parameter, includes an
		unsupported parameter value (other than grant type),
		repeats a parameter, includes multiple credentials,
		utilizes more than one mechanism for authenticating the
		client, or is otherwise malformed.',
		self::INVALID_GRANT => 'Client authentication failed (e.g. unknown client, no
		client authentication included, or unsupported
		authentication method).  The authorization server MAY
		return an HTTP 401 (Unauthorized) status code to indicate
		which HTTP authentication schemes are supported.  If the
		client attempted to authenticate via the "Authorization"
		request header field, the authorization server MUST
		respond with an HTTP 401 (Unauthorized) status code, and
		include the "WWW-Authenticate" response header field
		matching the authentication scheme used by the client.',
		self::UNAUTHORIZED_CLIENT => 'The provided authorization grant (e.g. authorization
		code, resource owner credentials) or refresh token is
		invalid, expired, revoked, does not match the redirection
		URI used in the authorization request, or was issued to
		another client.',
		self::UNSUPPORTED_GRANT_TYPE => '',
		self::INVALID_SCOPE => 'The requested scope is invalid, unknown, malformed, or
		exceeds the scope granted by the resource owner.'
	);

	/**
	 * REQUIRED.  A single ASCII [USASCII] error code from the
	 * following:
	 * invalid_request
	 * 		The request is missing a required parameter, includes an
	 * 		unsupported parameter value (other than grant type),
	 * 		repeats a parameter, includes multiple credentials,
	 * 		utilizes more than one mechanism for authenticating the
	 * 		client, or is otherwise malformed.
	 * invalid_client
	 * 		Client authentication failed (e.g. unknown client, no
	 * 		client authentication included, or unsupported
	 * 		authentication method).  The authorization server MAY
	 * 		return an HTTP 401 (Unauthorized) status code to indicate
	 * 		which HTTP authentication schemes are supported.  If the
	 * 		client attempted to authenticate via the "Authorization"
	 * 		request header field, the authorization server MUST
	 * 		respond with an HTTP 401 (Unauthorized) status code, and
	 * 		include the "WWW-Authenticate" response header field
	 * 		matching the authentication scheme used by the client.
	 * invalid_grant
	 * 		The provided authorization grant (e.g. authorization
	 * 		code, resource owner credentials) or refresh token is
	 * 		invalid, expired, revoked, does not match the redirection
	 * 		URI used in the authorization request, or was issued to
	 * 		another client.
	 * unauthorized_client
	 * 		The authenticated client is not authorized to use this
	 * 		authorization grant type.
	 * unsupported_grant_type
	 * 		The authorization grant type is not supported by the
	 * 		authorization server.
	 * invalid_scope
	 * 		The requested scope is invalid, unknown, malformed, or
	 * 		exceeds the scope granted by the resource owner.
	 * Values for the "error" parameter MUST NOT include characters
	 * outside the set %x20-21 / %x23-5B / %x5D-7E.
	 * @var string
	 */
	public $error;

	/**
	 * OPTIONAL.  A human-readable ASCII [USASCII] text providing
	 * additional information, used to assist the client developer in
	 * understanding the error that occurred.
	 * Values for the "error_description" parameter MUST NOT include
	 * characters outside the set %x20-21 / %x23-5B / %x5D-7E.
	 * @var string
	 */
	public $error_description;

	/**
	 * OPTIONAL.  A URI identifying a human-readable web page with
	 * information about the error, used to provide the client
	 * developer with additional information about the error.
	 * Values for the "error_uri" parameter MUST conform to the URI-
	 * Reference syntax, and thus MUST NOT include characters outside
	 * the set %x21 / %x23-5B / %x5D-7E.
	 * @var string
	 */
	public $error_uri;

	/**
	 * REQUIRED.  The access token issued by the authorization server.
	 * @var string
	 */
	public $access_token;

	/**
	 * REQUIRED.  The type of the token issued as described in
	 * Section 7.1.  Value is case insensitive.
	 * @var string
	 */
	public $token_type;

	/**
	 * RECOMMENDED.  The lifetime in seconds of the access token.  For
	 * example, the value "3600" denotes that the access token will
	 * expire in one hour from the time the response was generated.
	 * If omitted, the authorization server SHOULD provide the
	 * expiration time via other means or document the default value.
	 * @var unknown_type
	 */
	public $expires_in;


	/**
	 * OPTIONAL.  The refresh token which can be used to obtain new
	 * access tokens using the same authorization grant as described
	 * in Section 6.
	 * @var string
	 */
	public $refresh_token;

	/**
	 * OPTIONAL, if identical to the scope requested by the client,
	 * otherwise REQUIRED.  The scope of the access token as described
	 * by Section 3.3.
	 * @var string
	 */
	public $scope;
}