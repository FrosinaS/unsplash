<?php


namespace Frosinas\Unsplash\Services;

use Frosinas\Unsplash\Traits\UnsplashConfig;
use GuzzleHttp\Client;

class UnsplashSdk implements UnsplashSdkInterface
{
    use UnsplashConfig;
    /**
     * @var UnsplashAuthorizationServiceInterface
     */
    private $unsplashAuthorizationService;

    /**
     * @var UnsplashAuthenticationServiceInterface
     */
    private $unsplashAuthenticationService;

    /**
     * @var TokenServiceInterface
     */
    private $tokenService;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * UnsplashSdk constructor.
     * @param UnsplashAuthorizationServiceInterface $unsplashAuthorizationService
     * @param UnsplashAuthenticationServiceInterface $unsplashAuthenticationService
     * @param TokenServiceInterface $tokenService
     * @param Client $httpClient
     */
    public function __construct(UnsplashAuthorizationServiceInterface $unsplashAuthorizationService,
                                UnsplashAuthenticationServiceInterface $unsplashAuthenticationService,
                                TokenServiceInterface $tokenService,
                                Client $httpClient)
    {
        $this->unsplashAuthorizationService = $unsplashAuthorizationService;
        $this->unsplashAuthenticationService = $unsplashAuthenticationService;
        $this->tokenService = $tokenService;
        $this->httpClient = $httpClient;
    }

    /**
     * Call /me endpoint to get current user info
     */
    public function getMe()
    {
        $scope = 'read_user';

        return $this->executeEndpoint($scope, $this->getApiUrl() . 'me');
    }

    /**
     * Call /photos endpoint get get list of photos
     */
    public function getPhotos()
    {
        $scope = 'public';

        return $this->executeEndpoint($scope, $this->getApiUrl() . 'photos');
    }

    /**
     * Call /collections endpoint to get list of collections
     */
    public function getCollections()
    {
        $scope = 'public';

        return $this->executeEndpoint($scope, $this->getApiUrl() . 'collections');
    }

    /**
     * @param $scope
     * @param $endpoint
     * @return mixed
     */
    private function executeEndpoint($scope, $endpoint)
    {
        $self = &$this;

        return $this->handleEndpoint($scope, (function ($token = null) use ($self, $endpoint) {
            return $self->httpClient->get($endpoint,
                $self->getOptions($token));
        }));
    }


    /**
     * @param $scope
     * @param $func
     * @return mixed
     */
    public function handleEndpoint($scope, $func)
    {
        $token = null;
        if ($scope !== 'public') {
            $token = $this->tokenService->getTokenByScope($scope);

            if (!$token) {
                return $this->unsplashAuthorizationService->authorize($scope);
            }
        }
        return $result = $func($token);
    }

    /**
     * @param $token
     * @return array
     */
    public function getOptions($token)
    {
        $bearer = $token ? ', Bearer ' . $token : '';

        return [
            'headers' => [
                'Authorization' => 'Client-ID ' . $this->getClientId() . $bearer
            ]
        ];
    }

    /**
     * @return mixed
     */
    private function getApiUrl()
    {
        return 'https://api.unsplash.com/';
    }

}
