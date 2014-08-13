<?php namespace Twitter\Api\Tweet;

use Twitter\Api\Model;

class Tweet extends Model {

    protected static $rules =[
        'message'           => 'required|max:140',
        'user_id'           => 'required|exists:users,id',
        'original_tweet_id' => 'exists:tweets,id',
    ];

    /** @var string */
    protected $table = 'tweets';

    /** @var array */
    protected $hidden = [];

    protected $fillable = [
        'message',
        'user_id',
        'original_tweet_id',
    ];

    public function user() {

        return $this->belongsTo('\\Twitter\\Api\\User\\User');
    }

    public function originalTweet() {

        return $this->belongsTo("\\Twitter\\Api\\Tweet\\Tweet");
    }
}