<?php


namespace Frosinas\Unsplash\Services;


interface UnsplashSdkInterface
{
    /**
     * @return mixed
     */
    public function getMe();

    /**
     * @return mixed
     */
    public function getPhotos();

    /**
     * @return mixed
     */
    public function getCollections();
}
