<?php

namespace App\Controllers\Traits\HC;

// use App\Models\Database\Common;

trait storedTextTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]
    
    // Login Screen Traits
    function loginScreen()
    {
        $stored_text = [
            'LoginTitle' => 'LoginTitle',
            'LoginHeader' => 'LoginHeader',
            'UsernameLabel' => 'UsernameLabel',
            'UsernamePlaceholder' => 'UsernamePlaceholder',
            'PasswordLabel' => 'PasswordLabel',
            'PasswordPlaceholder' => 'PasswordPlaceholder',
            'LoginButton' => 'LoginButton',
            'RestButton' => 'RestButton',
            'SignupPara' => 'SignupPara',
            'SignupAnchor' => 'SignupAnchor',
            'SignupLink' => 'SignupLink',
        ];
    }
}