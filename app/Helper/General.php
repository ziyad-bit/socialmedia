<?php

use App\Models\Languages;

###############################     languages      ####################################
function default_lang():string
{
    return config('app.locale');
};

function lang_rtl():array
{
    return Languages::where('direction','rtl')->pluck('abbr')->toArray();
};

###############################     middlewares      ####################################

function adminMiddleware():array
{
    return [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:admins' ];
}

