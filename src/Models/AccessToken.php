<?php


namespace Frosinas\Unsplash\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $table = 'access_tokens';

    protected $fillable = [
        'access_token'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scopes()
    {
        return $this->hasMany(AccessTokenScopes::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $scope
     */
    public function saveScope($scope)
    {
        $this->scopes()->save($scope);
    }

    /**
     * @param $user
     */
    public function saveUser($user)
    {
        $this->user()->associate($user);
        $this->save();
    }

}
