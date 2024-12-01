<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


use App\Controllers\Chat; 
use App\Controllers\Login;
use App\Controllers\SignUp;
use App\Controllers\GoogleLogin;
use App\Controllers\Home;
use App\Controllers\ForgotPassword;
use App\Controllers\Group;
use App\Controllers\Img;
use App\Controllers\Member;
use App\Controllers\Msg;
use App\Controllers\Profile;


//meaning: Login = class, index = method (index())
$routes->get('/',function (){
    // session()->destroy();
    return redirect()->to('/login');
});


$routes->get('login/', [Login::class, "index"]);
$routes->post('login/validation', [Login::class, "validation"]);
$routes->get('logout/', [Login::class, "logout"]);


$routes->get('forgot/', to: [ForgotPassword::class, "index"]);
$routes->post('forgot/validation', to: [ForgotPassword::class, "validation"]);
$routes->post('forgot/confirmation', [ForgotPassword::class, "confirmation"]);
$routes->post( 'forgot/change', [ForgotPassword::class, "change"]);


$routes->get('signUp/', [SignUp::class, "index"]);
$routes->post('signUp/validation', [SignUp::class, "validation"]);
$routes->post('signUp/confirmation', [SignUp::class, "confirmation"]);


//google auth routes
$routes->get('googleLogin/', [GoogleLogin::class, "index"]);
$routes->get('googleCallback/', [GoogleLogin::class, "callback"]);


$routes->get('chat/', [Chat::class, "index"]);
$routes->post('chat/', [Chat::class, "index"]);



$routes->post(from: 'msg/add', to:[Msg::class, "add"]);
$routes->post(from: 'msg/remove', to:[Msg::class, "remove"]);



$routes->post(from: 'group/load', to:[Group::class, "load"]);
$routes->post(from: 'group/search', to:[Group::class, "search"]);

$routes->post(from: 'group/join/request', to:[Group::class, "joinRequest"]);
$routes->post(from: 'group/join', to:[Group::class, "join"]);

$routes->post(from: 'member/load', to:[Member::class, "load"]);
$routes->post(from: 'member/search', to:[Member::class, "search"]);
$routes->post(from: 'member/remove', to:[Member::class, "remove"]);


$routes->get(from: 'img/(:num)', to:[Img::class, "display"]);
// angular 




$routes->group(
    '', 
    ['filter' => 'cors'], static function (RouteCollection $routes): void {
        $routes->options('api/(:any)', static function () {});
    }   
);


// add angular 
$routes->get( from: 'profile/',  to:[Profile::class, "index"]);

$routes->group(
    'api', ['filter' => 'cors:api'], 
    static function (RouteCollection $routes): void {
        
        // $routes->get( from: 'profile/',  to:[Profile::class, "index"]);

        $routes->get(from: 'profile/load', to:[Profile::class, "load"]);

        $routes->post(from: 'profile/img', to:[Profile::class, "img"]);
        $routes->get(from: 'profile/img/(:num)', to:[Profile::class, "displayImg/$1"]);
        $routes->post(from: 'profile/update', to:[Profile::class, "update"]);

        // $routes->get(from: "profile", to: "Profile::index");
        // $routes->options(from: 'profile', to: static function () {});
        // $routes->options(from: 'profile/(:any)', to: static function () {});

    }
);




// $routes->get('(:any)', function () {
//     return view('index.html');
// });