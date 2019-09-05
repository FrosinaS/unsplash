<?php


namespace Frosinas\Unsplash\Services;


interface TokenServiceInterface
{
    /**
     * @param $scopes
     * @return mixed
     */
    public function getTokenByScope($scopes);

    /**
     * @param $scopes
     * @param $token
     * @return mixed
     */
    public function saveToken($scopes, $token);
}
