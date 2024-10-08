<?php
namespace App\Business\Http\Api;

use BlueFission\BlueCore\BaseController;
use BlueFission\Services\Request;

class ChatController extends BaseController {

    public function __construct( )
    {
        parent::__construct();
    }
    
    public function send( Request $request )
    {
        $app = \App::instance();
        $botman = $app->service('botman');

        $botman->listen();
    }
}