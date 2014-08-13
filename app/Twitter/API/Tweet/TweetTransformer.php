<?php namespace Twitter\Api\Tweet;

use Twitter\Api\User\UserTransformer;
use League\Fractal\TransformerAbstract;
use Twitter\Api\Hateoas;

class TweetTransformer extends TransformerAbstract {

    use Hateoas;

    protected $availableIncludes = [
        'user',
        'original_tweet',
    ];

    public function includeUser(Tweet $resource) {

        return $this->collection($resource->user()->get(), new UserTransformer);
    }

    public function includeOriginalTweet(Tweet $resource) {

        return $this->collection($resource->originalTweet()->get(), new TweetTransformer);
    }

    public function transform(Tweet $resource) {

        return [
            'id'                => (int) $resource->id,
            'user_id'           => (int) $resource->user_id,
            'original_tweet_id' => (int) $resource->original_tweet_id,
            'message'           => (string) $resource->message,
            'created_at'        => (string) $resource->created_at,
            '_links'            => $this->hateoas($resource)
        ];
    }

}