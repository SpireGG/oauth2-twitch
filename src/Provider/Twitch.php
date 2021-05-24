<?php

namespace SpireGG\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use SpireGG\OAuth2\Client\Provider\Exception\TwitchIdentityProviderException;

class Twitch extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * API Domain
     *
     * @var string
     */
    public $authDomain = 'https://id.twitch.tv';
    public $apiDomain = 'https://api.twitch.tv';

    /**
     * Get authorization URL to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->authDomain . '/oauth2/authorize';
    }

    /**
     * Get access token URL to retrieve token
     *
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->authDomain . '/oauth2/token';
    }

    /**
     * Get provider URL to retrieve user details
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiDomain . '/helix/users';
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [
            'user:read:email'
        ];
    }

    /**
     * Check a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array $data Parsed response data
     * @return void
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw TwitchIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw TwitchIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new TwitchResourceOwner(isset($response['data']) ? $response['data'] : $response);
    }

    /**
     * Since August 8th, 2016 Kraken requires a Client-ID header to be sent
     *
     * @return array
     */
    protected function getDefaultHeaders()
    {
        return ['Client-ID' => $this->clientId];
    }

    /**
     * Adds token to headers
     *
     * @param AccessToken $token
     * @return array
     */
    protected function getAuthorizationHeaders($token = null)
    {
        return $token ? ['Authorization' => 'Bearer ' . $token->getToken()] : [];
    }
}
