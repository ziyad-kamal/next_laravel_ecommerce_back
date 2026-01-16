<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.Admin.{id}', function ($user, $id) {
    return true;
});
