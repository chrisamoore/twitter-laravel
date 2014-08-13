<?php namespace Twitter\Api\Message;

use League\Fractal\TransformerAbstract;
use Twitter\Api\Hateoas;
use Twitter\Api\User\UserTransformer;

class MessageTransformer extends TransformerAbstract {

    use Hateoas;

    protected $availableIncludes = [
        'from_user',
        'to_user',
    ];

    public function includeFromUser(Message $resource) {

        return $this->collection($resource->fromUser()->get(), new UserTransformer);
    }

    public function includeToUser(Message $resource) {

        return $this->collection($resource->toUser()->get(), new UserTransformer);
    }

    public function transform(Message $resource) {

        return [
            'id'           => (int) $resource->id,
            'from_user_id' => (int) $resource->from_user_id,
            'to_user_id'   => (int) $resource->to_user_id,
            'message'      => (string) $resource->message,
            'created_at'   => (string) $resource->created_at,
            '_links'       => $this->hateoas($resource)
        ];
    }

}