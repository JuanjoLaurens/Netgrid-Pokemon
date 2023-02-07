<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikedPokemon;
use App\Models\HatedPokemon;
use Illuminate\Support\Facades\DB;

class PokemonController extends Controller
{


    public function fetchLikedPokemons($user_id){
        return $pokemons = LikedPokemon::where('user_id', $user_id)->get();
    }

    public function fetchHatedPokemons($user_id){
        return $pokemons = HatedPokemon::where('user_id', $user_id)->get();
    }

    public function likePokemon(Request $request, $user_id, $poke_id){

        $likedPokemon = LikedPokemon::where([["user_id",  $user_id], ["pokemon_id", $poke_id]])->get();
        $hatedPokemon = HatedPokemon::where([["user_id",  $user_id], ["pokemon_id", $poke_id]])->get();

        $likedPokemons = LikedPokemon::where("user_id", $user_id)->get();
        $numberOfLiked = $likedPokemons->count();

        if($likedPokemon->count() > 0 ){
            return "Ya te gusta este pokemon";
        }
        else if($numberOfLiked > 10){
            return "No puedes elegir más de 10 pokemones";
        }
        else{
            $pokemon= new LikedPokemon();

            $pokemon->pokemon_id = $request->pokemon['pokemon_id'];
            $pokemon->name = $request->pokemon['name'];
            $pokemon->user_id = $request->pokemon['user_id'];

            $pokemon->save();

            if($hatedPokemon->count() >0){
                $hatedPokemon->first()->delete();
            }

            return "Te gusta ".$request->pokemon["name"];
        }

    }

    public function hatePokemon(Request $request,$user_id, $poke_id){

        $likedPokemon = LikedPokemon::where([["user_id",  $user_id], ["pokemon_id", $poke_id]])->get();
        $hatedPokemon = HatedPokemon::where([["user_id",  $user_id], ["pokemon_id", $poke_id]])->get();

        $hatedPokemons = HatedPokemon::where("user_id", $user_id)->get();
        $numberOfHated = $hatedPokemons->count();

        if($hatedPokemon->count() > 0 ){
            return "No te gusta ese pokemon";
        }
        else if($numberOfHated > 10){
            return "No puedes elegir más de 10 pokemones";
        }
        else{
            $pokemon= new HatedPokemon();

            $pokemon->pokemon_id = $request->pokemon['pokemon_id'];
            $pokemon->name = $request->pokemon['name'];
            $pokemon->user_id = $request->pokemon['user_id'];

            $pokemon->save();

            if($likedPokemon->count() >0){
                $likedPokemon->first()->delete();
            }

            return "No te gusta ".$request->pokemon["name"];
        }
    }

    public function checkIfLiked($poke_id){
        $likedPokemon = LikedPokemon::where("pokemon_id", $poke_id)->get();

        if($likedPokemon->count() > 0 ){
            return true;
        }

        return false;
    }

    public function checkIfHated($poke_id){
        $hatedPokemon = HatedPokemon::where("pokemon_id", $poke_id)->get();

        if($hatedPokemon->count() > 0 ){
            return true;
        }
        return false;
    }

}
