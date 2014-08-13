<?php namespace Twitter\Api\Message;

use Twitter\Api\Model;

class Message extends Model {

    protected static $rules = [
        'message'      => 'required',
        'from_user_id' => 'required|exists:users,id',
        'to_user_id'   => 'required|exists:users,id',
    ];

    /** @var string */
    protected $table = 'messages';

    /** @var array */
    protected $hidden = [];

    protected $fillable = [
        'message',
        'from_user_id',
        'to_user_id,'
    ];

    public function fromUser() {

        return $this->belongsTo("\\Twitter\\Api\\User\\User");
    }

    public function toUser() {

        return $this->belongsTo("\\Twitter\\Api\\User\\User");
    }
}