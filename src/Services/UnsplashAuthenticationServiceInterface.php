<?php


namespace Frosinas\Unsplash\Services;


interface UnsplashAuthenticationServiceInterface
{
    public function authenticate($code, $scopes, $headed);
}
