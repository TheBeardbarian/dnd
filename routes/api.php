<?php

use Illuminate\Http\Request;
use App\characterInfo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::put('character-info', function(Request $request) {
  $body=$request->getContent();
  $body_decoded = json_decode($body);


  $character = new characterInfo();
  $character->name = $body_decoded->name;
  $character->race = $body_decoded->race;
  $character->class = $body_decoded->class;
  $character->sex = $body_decoded->sex;

  Log::debug('PUT api/character-info', [
    'body' => $body,
    'body_decoded' => json_encode($body_decoded),
    'character' => json_encode($character),
  ]);

  $character->save();
});

Route::get('character-info/{id}', function($id) {
  Log::debug("GET api/character-info/$id", [
  ]);

  $character = characterInfo::find($id);
  echo json_encode($character);
});

Route::delete('character-info/{id}', function($id) {
  Log::debug("delete character-info/$id", [
  ]);

  $character = characterInfo::find($id);
  echo "$character->name will be deleted.";
  $character->delete();
});
