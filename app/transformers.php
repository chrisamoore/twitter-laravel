<?php
/*
|--------------------------------------------------------------------------
| API Transformers
|--------------------------------------------------------------------------
|
| Here is where you can register all of the transformers for an api.
|
*/


API::transform('Twitter\\Api\\User\\User', '\\Twitter\\Api\\User\\UserTransformer');
API::transform('Twitter\\Api\\Message\\Message', '\\Twitter\\Api\\Message\\MessageTransformer');
API::transform('Twitter\\Api\\Tweet\\Tweet', '\\Twitter\\Api\\Tweet\\TweetTransformer');
