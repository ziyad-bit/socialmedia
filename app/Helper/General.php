<?php

function default_lang():string
{
    return config('app.locale');
};

function adminMiddleware():array
{
    return [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:admins' ];
}
