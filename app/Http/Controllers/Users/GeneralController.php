<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class GeneralController extends Controller
{
    public function getDataDeletion():View
    {
        return view('users.general.data_deletion');
    }

    public function getPrivacyPolicy():View
    {
        return view('users.general.privacy_policy');
    }
}
