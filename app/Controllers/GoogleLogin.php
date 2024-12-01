<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google_Client;
use Google_Service_Oauth2;

use App\Models\UserModel;


class GoogleLogin extends Controller{

    public function __construct(){

        helper('url');
        // helper('cookie');

    }


    public function index(){

        $client = new Google_Client();
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(base_url('googleCallback/'));
        $client->addScope("email");
        $client->addScope("profile");

        // Generate Google login URL
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);

    }


    public function callback(){

        $client = new Google_Client();
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(base_url('googleCallback/'));

        $code = $this->request->getVar('code');

        if ( $code ) {

            $token = $client->fetchAccessTokenWithAuthCode( $code );
            $client->setAccessToken($token);

            // Get user profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email = $google_account_info->email;
            $username = $google_account_info->name;
            $fname = $google_account_info->givenName;
            $lname = $google_account_info->familyName;
            $googleID = $google_account_info->id;

            // $gender = $google_account_info->gender;
            // print_r($google_account_info);


            $user = array(
                "fname"     =>$fname,
                "lname"     =>$lname,
                "email"     =>$email,
                "username"  =>$username,
                "googleID"  =>$googleID
            );

         
            $userModel = model(UserModel::class);//load model

            
            if(!$userModel->checkEmailExistence($email)){// new email case
        
                if(!$userModel->googleAdd($user)){ // save user in db if possible
                    return view(
                        "Global/alert",
                        array(
                            "msg" => "failed to add google user",
                            "redirect" => "signUp/"
                        )
                    );
                }

            }else{

                if(!$userModel->googleUpdate($user)){ // update user data in db if possible
                    return view(
                        "Global/alert",
                        array(
                            "msg" => "failed to update google user",
                            "redirect" => "signUp/"
                        )
                    );
                }

            }

            // Save the user information in session
            session()->set('user', [
                "fname"     => $fname,
                "lname"     => $lname,
                'username'  => $username,
                'email'     => $email,
                "loggedIn"  => true
            ]);

            return redirect()->to(base_url('chat/'));

        }

    }

}
