<?php namespace Twitter\Api;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Validation\Validator;

class Model extends Eloquent {

    /**
     * Error message bag
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validation rules
     *
     * @var Array
     */
    protected static $rules = array();

    /**
     * Validator instance
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    public function __construct(array $attributes = array(), Validator $validator = null) {

        parent::__construct($attributes);

        $this->validator = $validator ? : \App::make('validator');
    }

    /**
     * Listen for save event
     */
    protected static function boot() {

        parent::boot();

        static::saving(function ($model) {

            return $model->validate();
        });
    }

    /**
     * @return bool
     * @throws ResourceException
     */
    public function validate() {

        //This bit of code appends the model's id to the validation rule if it finds "unique" in the string, necessary for PUTS.
        if ($this->id) {
            $newRules = [];
            foreach (static::$rules as $key => $value) {
                $newRules[$key] = preg_replace("/(unique:.*,.*)(\\|.*)?/u", "$1,{$this->id}$2", $value);
            }
        }
        $rulesToUse = $this->id ? $newRules : static::$rules;

        $v = $this->validator->make($this->attributes, $rulesToUse);

        if ($v->passes()) {
            return true;
        }

        $this->setErrors($v->messages());
        $className = get_class($this);

        throw new ResourceException("Validation on $className failed.", $v->messages());
    }

    /**
     * Set error message bag
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected function setErrors($errors) {

        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors() {

        return $this->errors;
    }

    /**
     * Inverse of wasSaved
     */
    public function hasErrors() {

        return ! empty($this->errors);
    }

    public function getRoute() {

        return self::getBaseRoute() . "/" . $this->id;
    }

    public static function getBaseRoute() {

        $className = class_basename(get_called_class());
        $prefix = \Config::get('api::config.prefix');

        return url("/$prefix/" . strtolower(str_plural($className)));
    }
}