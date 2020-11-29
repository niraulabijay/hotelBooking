<?php
/**
 * Created by PhpStorm.
 * User: Bijay
 * Date: 11/26/2020
 * Time: 3:05 PM
 */

namespace App;


use Illuminate\Support\Facades\Storage;

class UStates
{
    public static function getStates(){
        $json = Storage::disk('public')->get('united-states.json');
        $states = json_decode($json, true);
        return $states;
    }
}