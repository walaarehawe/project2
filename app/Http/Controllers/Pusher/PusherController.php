<?php

namespace App\Http\Controllers\Pusher;

use App\Events\NewOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function pusher(){
        event(new NewOrder('hello world'));
    }
}
