<?php

namespace App\Http\Controllers;

use Auth;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UiController extends Controller
{

    /**
     * Grab the colors css based on the organization settings
     *
     * @return \Illuminate\Http\Response
     */
    public function colors()
    {

        // TODO - grab colors from database based on the company/customer

        return response()
            ->view('colors')
            ->header('Content-Type', 'text/css');
    }

}
