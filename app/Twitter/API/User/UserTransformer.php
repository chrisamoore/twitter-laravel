<?php namespace Twitter\Api\User;

use League\Fractal\TransformerAbstract;
use Twitter\Api\Hateoas;

class UserTransformer extends TransformerAbstract {

    use Hateoas;

    protected $availableIncludes = [
    ];


    public function transform(User $resource) {

        return [
            'id'               => (int) $resource->id,
            'email'            => (string) $resource->email,
            'active'           => (boolean) $resource->active,
            'activation_token' => (string) $resource->activation_token,
            'created_at'       => (string) $resource->created_at,
            'updated_at'       => (string) $resource->updated_at,
            '_links'           => $this->hateoas($resource)
        ];
    }

}