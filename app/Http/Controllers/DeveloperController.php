<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Instagram\Api;
use Instagram\Auth\Checkpoint\ImapClient;
use Instagram\Exception\InstagramException;
use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class DeveloperController extends Controller
{
    //
    public function test(){
        return cuaca("dki jakarta");
        // $cachePool = new FilesystemAdapter('Instagram', 0, __DIR__ . '/../cache');
        // $api = new Api($cachePool);
        // $profile = $api->getProfile('alatanindonesia');
        // dd($profile);
    }
}
