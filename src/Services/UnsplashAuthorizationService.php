<?php


namespace Frosinas\Unsplash\Services;


use Frosinas\Unsplash\Traits\UnsplashConfig;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Array_;

class UnsplashAuthorizationService implements UnsplashAuthorizationServiceInterface
{
    use UnsplashConfig;

    /**
     * @param $scopes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authorize($scopes)
    {
        $url = $this->composeAuthorizationUrl($scopes);

        return Redirect::away($url);
    }


    /**
     * Compose the authorize url
     *
     * @param $scopes
     * @return string
     */
    public function composeAuthorizationUrl($scopes)
    {
        return $this->getApiUrl()
            . $this->getAuthorizationEndpoint()
            . $this->getAuthorizationParameters($scopes);

    }

    /**
     * Get authorize endpoint
     *
     * @return string
     */
    private function getAuthorizationEndpoint()
    {
        return 'oauth/authorize';
    }

    /**
     * Get query string parameters for authorize endpoint
     */
    private function getAuthorizationParameters($scopes)
    {
        return '?client_id=' . $this->getClientId()
            . '&redirect_uri=' . $this->getRedirectUrl() . '?scopes=' . json_encode($scopes).'&headed='. session('intended')
            . '&response_type=code'
            . '&scope=' . $this->prepareScopes($scopes);
    }

    /**
     * @param $scopes
     * @return string
     */
    private function prepareScopes($scopes)
    {
        if ($scopes instanceof Array_) {
            return implode('+', $scopes);
        }
        return $scopes;
    }

}
