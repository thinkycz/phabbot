<?php

namespace App\Http\Controllers;

use App\Services\Fetcher;

class HomeController extends Controller
{
    public function index(Fetcher $fetcher)
    {
//        dd($fetcher->phid('PHID-CMIT-5bw36fedgogolazfrccd')->sendSlackNotification());

        return view('home');
    }
}
