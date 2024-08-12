<?php

namespace App\Controllers;

class Home extends MainController
{
    public function index()
    {
        $data = [
            'StoredText'=>[
                'Header' => 'Login Details',
                'ScreenTitle' => 'User Login',
                'UsernameLabel' => 'Login',
                'UsernamePlaceholder' => 'Enter your username',
                'PasswordLabel' => 'Password',
                'PasswordPlaceholder' => 'Enter your password',
                'LoginButton' => 'Submit',
                'RestButton' => 'Reset',
                'SignupPara' => 'Please click the below ',
                'SignupLink' => '',
                'SignupAnchor' => 'sign in link',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        return view('User/login', $data);
    }

    // public function accountList()
    // {
    //     $data = [
    //         'StoredText'=>[
    //             'Header' => 'Login Details',
    //             'ScreenTitle' => 'User Login',
    //             'ErrorStatus' => 'Error Status: ',
    //         ]
    //     ];

    //     // TODO:: User Session ID need to be handled from user login
    //     $accountDetails = $this->getDatafromDB('account', ['UserSessionID' => '01b9ff2b173400203b74b4cbec306d6f']);


    //     var_dump($accountDetails);
    //     die;
    //     // TODO:: link user default user

    //     return view('User/accounts', $data);
    // }
}
