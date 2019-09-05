<?php


namespace Frosinas\Unsplash\Services;


interface UnsplashAuthorizationServiceInterface
{
    public function authorize($scopes);
}
