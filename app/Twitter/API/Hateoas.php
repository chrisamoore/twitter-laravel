<?php namespace Twitter\Api;

use Illuminate\Support\Str;

/**
 * Trait Hateoas
 *
 * @author Christopher A. Moore <chris.a.moore@gmail.com>, <cmoore@undergroundelephant.com>
 */
trait Hateoas {
    public function hateoas($resource) {

        $fullyQualifiedName = get_class($this);
        $className          = substr($fullyQualifiedName, strrpos($fullyQualifiedName, '\\') + 1);

        return [
            'rel' => 'self',
            // Generate a URL by Pluralizing and lower casing the transformer name and ripping off the transformer using reflection
            'uri' => '/' . Str::plural(str_replace('transformer', '', Str::lower($className))) . '/' . $resource->id,
        ];
    }
}