<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show($user_name)
    {
        echo 'salut'.'<br>';
        echo 'ici show les tableaux et donc les images du user + bouton pour ajouter une image comme sur /image';
    }
}