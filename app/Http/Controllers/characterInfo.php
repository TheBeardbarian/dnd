<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\characterInfo as characterInfo_model;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class characterInfo extends Controller
{
    public function get($id) {
      Log::debug("GET api/character-info/$id", [
      ]);

      $character = characterInfo_model::find($id);
      echo json_encode($character);
    }

    public function put(Request $request) {
      Log::debug('PUT api/character-info', [
        'request.body' => $request->getContent(),
      ]);
      $validator = Validator::make($request->all(), [
        'name' => 'required|min:1|max:20',
        'race' => ['required', Rule::in([
          'dwarf', 'elf', 'halfling', 'human',
          'dragonborn', 'gnome', 'half-elf', 'half-orc', 'tiefling'
        ])],
        'class' => ['required', Rule::in([
          'barbarian', 'bard', 'cleric', 'druid',
          'fighter', 'monk', 'paladin', 'ranger',
          'rogue', 'sorcerer', 'warlock', 'wizard'
        ])],
        'sex' => 'required',
      ]);

      if ($validator->fails()) {
        Log::debug('PUT api/character-info:Error', [
          'errors' => $validator->errors(),
        ]);
        return json_encode($validator->errors());
      }

      $body=$request->getContent();
      $body_decoded = json_decode($body);


      $character = new characterInfo_model();
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
    }

    public function delete($id) {
      Log::debug("delete character-info/$id", [
      ]);

      $character = characterInfo_model::find($id);
      echo "$character->name will be deleted.";
      $character->delete();
    }

    public function getPage(Request $request) {
      $offset = $request->query('offset');
      $limit = $request->query('limit');

      Log::debug('GET api/character-info', [
        'offset' => $offset,
        'limit' => $limit,
      ]);

      $data = DB::table('character_info')
      ->offset($offset ? $offset : 0)
      ->limit($limit ? $limit : 10)
      ->get();

      echo json_encode($data);
    }
}
