<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait AdminTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    // # User Table Structure assigned
    public function userStructure()
    {
        $this->table = 'user';
        
        $this->primaryKeys = [
            'UserID'  => 'id'
        ];
        
        $this->allKeys = [
            'UserID'         => 'id',
            'UserSessionID'  => 'sessionid',
            'UserFirstName'  => 'first_name',
            'UserLastName'   => 'last_name',
            'UserContactNo'  => 'contactno',
            'Username'       => 'username',
            'UserPassword'       => 'password',
            'UserEmail'      => 'email',
            'UserStatus'     => 'status',
            'UserCreatedAt'  => 'created_at',
            'UserUpdatedAt'  => 'updated_at',
            'ProfilePic'     => 'profile_pic',
            'GoogleID'       => 'google_id'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # User History Table Structure assigned
    public function user_historyStructure()
    {
        $this->table = 'user_history';
        
        $this->primaryKeys = [
            'UserHistoryID' => 'id'
        ];
        
        $this->allKeys = [
            'UserHistoryID'                 => 'id',
            'UserHistorySessionID'          => 'loginsessionid',
            'UserSessionID'                 => 'userid',
            'UserHistoryStartedDateTime'    => 'starteddatetime',
            'UserHistoryEndedDateTime'      => 'endeddatetime',
            'UserHistoryStatus'             => 'status',
            'UserHistoryJWTToken'           => 'jwttoken'
        ];
        
        $this->foreignKeys = [
            'UserSessionID' => 'user'
        ];
    }

    # Multi User Access Table Structure assigned
    public function multiuseraccessStructure()
    {
        $this->table = 'multiuseraccess';
        
        $this->primaryKeys = [
            'MultiUserAccessID'  => 'id'
        ];
        
        $this->allKeys = [
            'MultiUserAccessID'     => 'id',
            'AccountSessionID'      => 'accountsessionid',
            'UserSessionID'         => 'usersessionid',
            'MultiUserAccess'       => 'access',
            'MultiUserAccessStatus' => 'status'
        ];
        
        $this->foreignKeys = [
            'UserSessionID' => 'user',
        ];
    }

    # Stackholder Table Structure assigned
    public function stackholderStructure()
    {
        $this->table = 'stackholder';
        
        $this->primaryKeys = [
            'StackholderID'         => 'id',
            'StackholderSessionID'  => 'sessionid'
        ];
        
        $this->allKeys = [
            'StackholderID'              => 'id',
            'StackholderSessionID'       => 'sessionid',
            'UserSessionID'             => 'linkedusersessionid',
            'StackholderName'           => 'name',
            'StackholderRelationship'   => 'relationship'
        ];
        
        $this->foreignKeys = [
            'UserSessionID' => 'user',
        ];
    }

    # User Stackholder Link Table Structure assigned
    public function userstackholderlinkStructure()
    {
        $this->table = 'userstackholderlink';
        
        $this->primaryKeys = [
            'UserStackholderLinkID'  => 'id'
        ];
        
        $this->allKeys = [
            'UserStackholderLinkID'         => 'id',
            'StackholderSessionID'          => 'stackholdersessionid',
            'UserSessionID'                 => 'usersessionid',
            'UserStackholderLinkIsPrimary'  => 'is_primary'
        ];
        
        $this->foreignKeys = [
            'StackholderSessionID' => 'stackholder',
            'UserSessionID'        => 'user',
        ];
    }
}