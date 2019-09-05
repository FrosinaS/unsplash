<?php


namespace Frosinas\Unsplash\Services;


use Frosinas\Unsplash\Traits\UnsplashConfig;
use GuzzleHttp\Client;

class UnsplashAuthenticationService implements UnsplashAuthenticationServiceInterface
{
    use UnsplashConfig;

    /**
     * @var TokenServiceInterface
     */
    private $tokenService;

    public function __construct(TokenServiceInterface $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @param $code
     * @param $scopes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate($code, $scopes, $headed)
    {
        $url = $this->composeTokenUrl();
        $params = $this->getTokenParameters($code, $scopes);
        $client = new Client();

        $response = $client->post($url, ['form_params' => $params]);

        $contents = $response->getBody()->getContents();

        if (isset($contents)) {
            $token = json_decode($contents)->access_token;
            $this->tokenService->saveToken($scopes, $token);
        }

        return redirect()->to('/' . $headed);
    }

    /**
     * @param $code
     * @return string
     */
    private function composeTokenUrl()
    {
        return $this->getApiUrl()
            . $this->getTokenUrl();
    }

    /**
     * @return string
     */
    private function getTokenUrl()
    {
        return 'oauth/token';
    }

    /**
     * Create array of parameters for the POST request for access token
     *
     * @param $code
     * @return array
     */
    private function getTokenParameters($code, $scopes)
    {
        return [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'redirect_uri' => $this->getRedirectUrl() . '?scopes=' . json_encode($scopes),
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
    }
}
