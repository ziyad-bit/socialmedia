<?php

namespace App\Classes\Messages;

use App\Models\Messages;
use Illuminate\Database\Eloquent\Collection;

class Msgs
{
    ###################################     get    ####################################
    public static function get(int $id):Collection
    {
        return Messages::with(['sender' => fn ($q)=> $q->selection()])
            ->getMsgs($id)->orderBydesc('id')->limit(6)->get();
    }

    ###################################     get_more     ####################################
    public static function get_more(int $id ,int $first_msg_id):Collection
    {
        return Messages::with(['sender' => fn ($q)=> $q->selection()])
            ->where  (fn($q)=>$q->auth_receiver()->where('sender_id', $id)->where('id', '<', $first_msg_id))
            ->orWhere(fn($q)=>$q->Where('receiver_id', $id)->auth_sender()->where('id', '<', $first_msg_id))
            ->orderBydesc('id')->limit(6)->get();
    }

    ###################################     getLast     ####################################
    public static function getLast($friends_ids)
    {
        return Messages::selection()->with(['sender','receiver'])
            ->where  (fn ($q) => $q->auth_receiver()->whereIn('sender_id', $friends_ids)->where('last',1))
            ->orWhere(fn ($q) => $q->WhereIn('receiver_id', $friends_ids)->auth_sender()->where('last',1))
            ->orderBydesc('id');
    }
}
