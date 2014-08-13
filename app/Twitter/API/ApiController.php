<?php namespace Twitter\Api;

use Dingo\Api\Routing\Controller;

use Dingo\Api\Exception\StoreResourceFailedException as StoreException;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateException;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteException;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Database\Eloquent\ModelNotFoundException as NotFoundException;

use Twitter\Api\User\User;
use Twitter\Api\Tweet\Tweet;
use Twitter\Api\Message\Message;

use Input;

/**
 * Class ApiController
 * Class that all model controllers inherit from that provides basic GET, POST, PUT, and DELETE functionality
 *
 * @property mixed repository
 */
class ApiController extends Controller {

    public static $modelName;

    /**
     * Display a listing of all the resources. [GET] Collection
     *
     * @return array
     * @return Response
     */
    public function index() {

        $name = static::$modelName;

        return $name::all();
    }


    /**
     * Display the specified resource. [GET]
     *
     * @param $ids
     *
     * @return array
     * @throws ResourceException
     */
    public function show($ids) {

        $name = static::$modelName;
        $idArray = explode(',', $ids);
        $models  = $name::whereIn('id', $idArray)->get();

        if (count($models) == 0) {
            throw new ResourceException(sprintf("Could not find %s with id(s): %s", $name, $ids), ["error" => "NOT_FOUND"]);
        }

        return $models;
    }

    /**
     * Save a new resource. [POST]
     *
     * @return array
     * @throws StoreException
     */
    public function store() {

        try {
            $name = static::$modelName;
            $model = $name::create(Input::all());

        } catch (ResourceException $e) {
            throw new StoreException(sprintf("Could not store new %s", $name), $e->getErrors());
        }

        return $model;
    }

    /**
     * Show the form for editing the specified resource. [PUT]
     *
     * @param $id
     *
     * @return array
     * @throws UpdateException
     */
    public function update($id) {

        try {
            $name = static::$modelName;
            $model = $name::find($id);
            $model->update(Input::all());

        } catch (NotFoundException $e) {
            throw new UpdateException(sprintf("Could not find %s with id: %s", $name, $id), ["error" => $e->getMessage()]);
        } catch (ResourceException $e) {
            throw new UpdateException(sprintf("Could not update %s with id: %s", $name, $id), $e->getErrors());
        }

        return $model;
    }


    /**
     * Remove the specified resource from storage. [DELETE]
     *
     * @param $id
     *
     * @return array
     * @throws DeleteException
     */
    public function destroy($id) {

        try {
            $name = static::$modelName;
            $name::destroy($id);
        } catch (NotFoundException $e) {
            throw new DeleteException(sprintf("Could not find %s with id: $id", $name, $id), ["error" => $e->getMessage()]);
        }

        return [
            'data'    => $id,
            'message' => sprintf(" %s deleted successfully.", $name),
        ];
    }
}