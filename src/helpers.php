<?php
if (!function_exists('getLoggedInUser')) {

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function getLoggedInUser()
    {
        return auth()->user();
    }
}
