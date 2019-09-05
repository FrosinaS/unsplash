<?php


namespace Frosinas\Unsplash\Services;


use Frosinas\Unsplash\Models\AccessToken;
use Frosinas\Unsplash\Models\AccessTokenScopes;
use PhpParser\Node\Expr\Array_;

class TokenService implements TokenServiceInterface
{

    /**
     * @param $scope
     * @return mixed
     */
    public function getTokenByScope($scope)
    {
        $user = getLoggedInUser();

        if ($user->accessTokens) {
            $accessToken = $user->accessTokens->filter(function ($token) use ($scope) {
                $result = $token->scopes->first(function ($tokenScope) use ($scope) {
                    return $tokenScope->scope === $scope;
                });
                if ($result) {
                    return $token;
                }
            })->first();
        }

        return $accessToken->access_token ?? false;
    }

    /**
     * @param $scopes
     * @param $token
     * @return mixed
     */
    public function saveToken($scopes, $token)
    {
        $user = getLoggedInUser();

        $newToken = AccessToken::create([
            'access_token' => $token
        ]);
        $newToken->saveUser($user);

        if ($scopes instanceof Array_) {
            foreach ($scopes as $scope) {
                $token = $this->getTokenByScope($scope);
                if (!$token) {
                    $newScope = AccessTokenScopes::create([
                        'scope' => $scope
                    ]);
                    $newToken->saveScope($newScope);
                }
            }
        } else {
            $token = $this->getTokenByScope($scopes);

            if (!$token) {
                $newScope = AccessTokenScopes::create([
                    'scope' => $scopes
                ]);
                $newToken->saveScope($newScope);
            }
        }
    }
}
