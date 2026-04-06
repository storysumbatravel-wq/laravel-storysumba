<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        // Simpan bahasa ke session
        if (in_array($lang, ['en', 'id'])) {
            session()->put('applocale', $lang);
        }
        return redirect()->back();
    }
}
