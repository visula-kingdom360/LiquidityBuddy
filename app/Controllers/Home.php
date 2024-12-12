<?php

namespace App\Controllers;
use DateTime;

class Home extends MainService
{
    public function index()
    {

        $is_login = session()->get('is_login');

        if(isset($is_login) && $is_login){
            return redirect()->to(base_url('/account/list'));
        }

        $data = [
            'StoredText'=>[
                "ScreenTitle" => "Login",
            "ErrorStatus" => "Error Login",
            "Header" => "Login to your Account",
            "EmailLabel" => "Email:",
            "EmailPlaceholder" => "Enter Email",
            "PasswordLabel" => "Password:",
            "PasswordPlaceholder" => "Enter Password",
            "GoogleIcon" => "assets/media/img/logo/iconfinder-new-google-favicon-682665.png",
            "LoginButton" => "Login",
            "SignupLink" => "/user/signup-page",
            "SignupPara" => "Not a member yet? ",
            "SignupAnchor" => "Sign up now",
            "PassworResetLink" => "/user/password-reset",
            "PassworResetPara" => "Forgot password? ",
            "PassworResetAnchor" => "Reset password"
            ]
        ];

        return view('User/login', $data);
    }

    public function loginValidation()
    {
        $dateTime  = strtotime(date_format(new DateTime(),'Y-m-d H:i:s'));
        $request_data = $this->handlePOSTBodyDataList();   

        $request_data['email'];
        $request_data['password'];

        $currentUserInfo = $this->getDatafromDB(['user'], 
            ['UserEmail' => $request_data['email']], 
            ['UserSessionID', 'UserPassword', 'UserEmail', 'GoogleID', 'UserFirstName', 'UserLastName', 'ProfilePic']);


        if(isset($currentUserInfo['error_id'])){
            // TODO:: Error logs
            // TODO:: return to login page handle
            return redirect()->to(base_url('/login'))->with('status',$currentUserInfo['error_message']);
        }

        if($currentUserInfo['GoogleID'] != ''){
            // TODO:: Error logs
            return redirect()->to(base_url('/login'))->with('status','This is a google link account, please use the google account to login in.');
        }

        

        if($this->encryptLogic($request_data['password']) != $currentUserInfo['UserPassword']){
            // TODO:: return to login page handle
            return redirect()->to(base_url('/login'))->with('status','Password incorrect');
        }


        $jwtData = [
            'UserSessionID' => 'UserSessionID'
            ];
        $jwtEncription = $this->generateJWT($jwtData);
                
        $insertUser = $this->insertDatatoDB('user_history', [
                'UserSessionID' => $currentUserInfo['UserSessionID'], 
                'UserHistoryStartedDateTime' => $dateTime, 
                'UserHistoryJWTToken' => $jwtEncription
            ]);

        if(isset($insertUser['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $data = [
            'user_fname' => $currentUserInfo['UserFirstName'],
            'user_lname' => $currentUserInfo['UserLastName'],
            'profile_pic' => $currentUserInfo['ProfilePic'],
            'user_id'     => $currentUserInfo['UserSessionID'],
            'jwt_encrypt' => $jwtEncription,
            'is_login' => true
            ];

        // Store user data in session
        session()->set($data);

        // Redirect to dashboard or any page
        return redirect()->to(base_url());
    }

    public function signup()
    {
        $is_login = session()->get('is_login');

        if(isset($is_login) && $is_login){
            return redirect('/account/list')->to(base_url());
        }

        $StoredText = [
            "ScreenTitle" => "Signup",
            "ErrorStatus" => "Signup Error",
            "Header" => "Login to your Account",
            "FirstNameLabel" => "First Name:",
            "FirstNamePlaceholder" => "First Name",
            "LastNameLabel" => "Last Name:",
            "LastNamePlaceholder" => "Last Name",
            "EmailLabel" => "Email:",
            "EmailPlaceholder" => "Enter Email",
            "PasswordLabel" => "Password:",
            "PasswordPlaceholder" => "Enter Password",
            "RePasswordLabel" => "Re-Password:",
            "RePasswordPlaceholder" => "Enter Re-Password",
            "GoogleIcon" => "assets/media/img/logo/iconfinder-new-google-favicon-682665.png",
            "SignupButton" => "Create a New Account",
            "LoginLink" => "/login",
            "LoginPara" => "Already have an account? ",
            "LoginAnchor" => "Login"
        ];

        $data = [
            'StoredText' => $StoredText
        ];

        return view('User/signup',$data);
    }

    public function signupValidation()
    {
        $dateTime  = strtotime(date_format(new DateTime(),'Y-m-d H:i:s'));
        $request_data = $this->handlePOSTBodyDataList();   

        $request_data['email'];
        $request_data['fname'];
        $request_data['lname'];
        $request_data['password'];
        $request_data['repassword'];

        $currentUserInfo = $this->getDatafromDB(['user'], 
            ['UserEmail' => $request_data['email']], 
            ['UserSessionID', 'UserPassword', 'UserEmail', 'GoogleID', 'UserFirstName', 'UserLastName', 'ProfilePic']);


        if(!isset($currentUserInfo['error_id']) || $currentUserInfo['error_id'] != '004'){
            if(!isset($currentUserInfo['error_id']) && $currentUserInfo['GoogleID'] != ''){
                // TODO:: Error logs
                return redirect()->to(base_url('login'))->with('status','This is a google link account, please use the google account to login in.');
            }
            // TODO:: Error logs
            return redirect()->to(base_url('login'))->with('status','Already have an account, please login below with your account.');
        }

        if($request_data['password'] != $request_data['repassword']){
            // TODO:: return to login page handle
            return redirect()->to(base_url('/user/signup-page'))->with('status','Password mismatch');
        }

        $userData = [
            'UserEmail' => $request_data['email'],
            'UserFirstName' => $request_data['fname'],
            'UserLastName' => $request_data['lname'],
            'UserPassword' => $this->encryptLogic($request_data['password'])
        ];

        $insertUser = $this->insertDatatoDB('user', $userData);

        if(isset($insertUser['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $user = $this->getDatafromDB(
                ['user'],
                ['UserEmail' => $userData['UserEmail']],
                ['UserSessionID', 'UserEmail', 'GoogleID', 'UserFirstName', 'UserLastName', 'ProfilePic']
            );

        if(isset($user['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

         $jwtData = [
            'UserSessionID' => $user['UserSessionID']
            ];
        $jwtEncription = $this->generateJWT($jwtData);
                
        $insertUser = $this->insertDatatoDB('user_history', [
                'UserSessionID' => $user['UserSessionID'], 
                'UserHistoryStartedDateTime' => $dateTime, 
                'UserHistoryJWTToken' => $jwtEncription
            ]);

        if(isset($insertUser['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $response = $this->insertDatatoDB('accountgroup', 
                ['UserSessionID' => $user['UserSessionID'], 'AccountGroupName' => 'Default']);

        if(isset($response['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $response = $this->insertDatatoDB('budget', 
                ['UserSessionID' => $user['UserSessionID'], 'BudgetName' => 'Default', 'BudgetAmount' => 0, 'BudgetPeriodic' => 'M']);

        if(isset($response['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $response = $this->insertDatatoDB('shop', 
                ['UserSessionID' => $user['UserSessionID'], 'ShopName' => 'Default']);

        if(isset($response['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $data = [
            'user_fname' => $user['UserFirstName'],
            'user_lname' => $user['UserLastName'],
            'profile_pic' => $user['ProfilePic'],
            'user_id'     => $user['UserSessionID'],
            'jwt_encrypt' => $jwtEncription,
            'is_login' => true
            ];

        // Store user data in session
        session()->set($data);

        // Redirect to dashboard or any page
        return redirect()->to(base_url());
    }

    public function passwordRest()
    {
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url());
        }

        $StoredText = [
            "ScreenTitle" => "Login",
            // "ErrorStatus" => "Test",
            "Header" => "Login to your Account",
            "OldPasswordLabel" => "Enter Password:",
            "OldPasswordPlaceholder" => "Enter Password",
            "NewPasswordLabel" => "Enter New Password:",
            "NewPasswordPlaceholder" => "Enter New  Password",
            "RePasswordLabel" => "Re-enter Password:",
            "RePasswordPlaceholder" => "Re-enter Password",
            "SignupButton" => "Create a New Account",
            "LoginLink" => "/login",
            "LoginPara" => "Already have an account? ",
            "LoginAnchor" => "Login"
        ];

        $data = [
            'StoredText' => $StoredText
        ];

        return view('FEUser/passswordReset',$data);
    

    }

    // Google account login and Sign in method
    public function googleAccountHandle($userData)
    {
        $dateTime  = strtotime(date_format(new DateTime(),'Y-m-d H:i:s'));

        $user = $this->getDatafromDB(
                ['user'],
                ['UserEmail' => $userData['UserEmail']],
                ['UserSessionID', 'UserEmail', 'GoogleID', 'UserFirstName', 'UserLastName', 'ProfilePic']
            );

        if(isset($user['error_id'])){
            
            // Error ID 0004 means no user found, this will create that google user to table
            if($user['error_id'] == "0004"){
                $insertUser = $this->insertDatatoDB('user', $userData);

                if(isset($insertUser['error_id'])){
                    // TODO:: DB access fail log need
                    // TODO:: Send to common Error
                }

                $user = $this->getDatafromDB(
                        ['user'],
                        ['UserEmail' => $userData['UserEmail']],
                        ['UserSessionID', 'UserEmail', 'GoogleID', 'UserFirstName', 'UserLastName', 'ProfilePic']
                    );

                if(isset($user['error_id'])){
                    // TODO:: DB access fail log need
                    // TODO:: Send to common Error
                }

            }else{
                // TODO:: DB access fail log need
                // TODO:: Send to common Error
            }
        }

        // if any details have changed in gmail like => FirstName, Last Name or Profile Picture this condtion will update the following data
        if($user['GoogleID'] == '' || $userData['UserFirstName'] != $user['UserFirstName'] || $userData['UserLastName'] != $user['UserLastName'] || $userData['ProfilePic'] != $user['ProfilePic']){

            if($user['GoogleID'] == ''){
                $updateList['GoogleID'] = $userData['GoogleID'];
            }

            if($userData['UserFirstName'] != $user['UserFirstName']){
                $updateList['UserFirstName'] = $userData['UserFirstName'];
            }

            if($userData['UserLastName'] != $user['UserLastName']){
                $updateList['UserLastName'] = $userData['UserLastName'];
            }
            
            if($userData['ProfilePic'] != $user['ProfilePic']){
                $updateList['ProfilePic'] = $userData['ProfilePic'];
            }

            $this->updateDBData('user', ['UserEmail' => $userData['UserEmail']], $updateList);

            $user = $this->getDatafromDB(
                    ['user'],
                    ['UserEmail' => $userData['UserEmail']],
                    ['UserSessionID', 'UserEmail', 'GoogleID', 'UserFirstName', 'UserLastName', 'ProfilePic']
                );

            if(isset($user['error_id'])){
                // TODO:: DB access fail log need
                // TODO:: Send to common Error
                return ['is_login' => false];
            }
        }

        // Google ID is not matching
        if($userData['GoogleID'] != $user['GoogleID']){
            // TODO:: Error Log
            // TODO:: Login Fail -> to redirect to login page
            return ['is_login' => false];
        }

        $jwtData = [
            'UserSessionID' => $user['UserSessionID']
            ];
        $jwtEncription = $this->generateJWT($jwtData);
                
        $insertUser = $this->insertDatatoDB('user_history', ['UserSessionID' => $user['UserSessionID'], 'UserHistoryStartedDateTime' => $dateTime, 'UserHistoryJWTToken' => $jwtEncription]);

        if(isset($insertUser['error_id'])){
            // TODO:: DB access fail log need
            // TODO:: Send to common Error
        }

        $data = [
            'user_fname' => $userData['UserFirstName'],
            'user_lname' => $userData['UserLastName'],
            'profile_pic' => $userData['ProfilePic'],
            'user_id' => $user['UserSessionID'],
            'jwt_encrypt' => $jwtEncription,
            'is_login' => true
            ];

        return $data;

    }
}
