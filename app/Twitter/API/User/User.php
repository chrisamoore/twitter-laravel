<?php namespace Twitter\Api\User;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Collection;
use Twitter\Api\Model;
use Twitter\Api\Tweet\Tweet;

class User extends Model implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    protected static $rules = [
        'email'            => 'required|email|unique:users,email',
        'handle'           => 'required|unique:users,handle',
        'profile_photo'    => 'url',
        'background_photo' => 'url',
        'website'          => 'url',
        'password'         => 'required',
        'active'           => 'required'
    ];

    /** @var string */
    protected $table = 'users';

    /** @var array */
    protected $hidden = ['password'];

    protected $fillable = [
        'email',
        'handle',
        'profile_photo',
        'background_photo',
        'website',
        'password',
        'active',
        'activation_token'
    ];

    public function __construct(array $attributes = array())
    {
        if (isset($attributes['password']) && \Hash::needsRehash($attributes['password'])) {
            $attributes['password'] = \Hash::make($attributes['password']);
        }

        parent::__construct($attributes);
    }

    public function tweets() {

        return $this->hasMany("\\Twitter\\Api\\Tweet\\Tweet");
    }

    public function messagesFrom() {

        return $this->hasMany("\\Twitter\\Api\\Message\\Message", "from_user_id");
    }

    public function messagesTo() {

        return $this->hasMany("\\Twitter\\Api\\Message\\Message", "to_user_id");
    }

    public function favorites() {

        $rows = \DB::table('tweets')
            ->join('favorites', 'tweets.id', '=', 'favorites.tweet_id')
            ->join('users', 'users.id', '=', 'favorites.user_id')
            ->where('users.id', '=', $this->id)->get();

        $tweets = [];
        foreach( $rows as $row )
        {
            $arr = ( array ) $row;
            $tweets[] = new Tweet($arr);
        }

        return new Collection($tweets);
    }

}
