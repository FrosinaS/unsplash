<?php


namespace Frosinas\Unsplash;


use Frosinas\Unsplash\Services\UnsplashAuthenticationServiceInterface;
use Frosinas\Unsplash\Services\UnsplashSdk;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UnsplashController extends BaseController
{
    private $sdk;

    private $unsplashAuthenticationService;

    public function __construct(UnsplashSdk $sdk, UnsplashAuthenticationServiceInterface $unsplashAuthenticationService)
    {
        $this->sdk = $sdk;
        $this->unsplashAuthenticationService = $unsplashAuthenticationService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function authorization(Request $request)
    {
        if ($request->has('code')) {
            $scopes = json_decode($request->get('scopes'));
            $code = $request->get('code');
            $headed = $request->get('headed');
            return $this->unsplashAuthenticationService->authenticate($code, $scopes, $headed);
        }
    }
}
