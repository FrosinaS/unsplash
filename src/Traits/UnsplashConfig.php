<?php

namespace Frosinas\Unsplash\Traits;

trait UnsplashConfig
{
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getApiUrl()
    {
        return config('unsplash.api_url');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getClientId()
    {
        return config('unsplash.client_id');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getClientSecret()
    {
        return config('unsplash.client_secret');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getRedirectUrl()
    {
        return config('unsplash.redirect_uri');
    }
}
