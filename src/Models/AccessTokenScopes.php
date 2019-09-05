<?php


namespace Frosinas\Unsplash\Models;


use Illuminate\Database\Eloquent\Model;

class AccessTokenScopes extends Model
{
    protected $table = 'access_token_scopes';

    protected $fillable = [
        'scope'
    ];

}
