<?php

namespace App\Http\Controllers;

use App\Events\PhabricatorWebhookReceived;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function handle(Request $request)
    {
        $phid = data_get($request->all(), 'object.phid');

        PhabricatorWebhookReceived::dispatch($phid);

        return response(['success' => true]);
    }
}
