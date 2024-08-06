<?php

namespace App\Controllers;

class MainController extends BlueprintController
{
    public function encryptLogic($password, $encrypt = true)
    {
        if($encrypt){
            return MD5($password); 
        }
    }

    public function FormattedStatus($status)
    {
        // switch to handle the status
        switch ($status) {
            case 'A':
                # Active Status
                return 'Active';
            case 'D':
                # Deactive Status
                return 'Dective';
            case 'L':
                # Locked Status
                return 'Locked';
            case 'I':
                # Inactive Status
                return 'Inactive';
            case 'C':
                # Cancelled Status
                return 'Cancelled';
            default:
                # Default Status
                return 'Default';
        }
    }
    
    public function passwordFormatHandler($password)
    {
        if(strlen($password) < 8){
            return $error = [
                        'error_id' => '0014',
                        'category' => 'Format_Issue',
                        'error_category' => 'Password Length',
                        'error_message'  => 'Please enter a password length higher than 8'
                    ];
        }

        return $response = ['success' => true];

    }
 
    public function contactNoFormatHandler($contactNo)
    {
        if(strlen($contactNo) < 9){
            return $error = [
                        'error_id' => '0015',
                        'category' => 'Format_Issue',
                        'error_category' => 'Contact No Length',
                        'error_message'  => 'Contact no length should be higher than 9'
                    ];
        }

        if(strlen($contactNo) > 16){
            return $error = [
                        'error_id' => '0016',
                        'category' => 'Format_Issue',
                        'error_category' => 'Contact No Length',
                        'error_message'  => 'Contact no length should be lower than 16'
                    ];
        }

        if(!is_numeric($contactNo)){
                    return $error = [
                    'error_id' => '0017',
                    'category' => 'Format_Issue',
                    'error_category' => 'Contact No Format',
                    'error_message'  => 'Contact no cannot have string values'
                ];
        }

        return $response = ['success' => true];

    }

    public function handleRequiredParameters($parameters, $requiredFeilds)
    {
        foreach ($requiredFeilds as $feilds) {
            # code...
            if(!isset($parameters[$feilds])){
                return $error = [
                        'error_id' => '0018',
                        'category' => 'Format_Issue',
                        'error_category' => 'Required Parameters',
                        'error_message'  => 'Required parameter "'.$feilds.'" is missing, and the follow is blocked'
                    ];
            }
        }
    }

    public function imageFormat($imageFormat)
    {
        // return base64_decode($imageFormat);
        return $imageFormat;
    }

    // ... (Inside your controller)
}
