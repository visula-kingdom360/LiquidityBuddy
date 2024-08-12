<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait AdminTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    // # Employee Table Structure assigned
    // public function employeeStructure()
    // {
    //     $this->table = 'employee';
    //     $this->primaryKeys = [
    //         'TaskID'    => 'EmployeeID'
    //     ];
    //     $this->allKeys = [
    //         'FullName'  => 'FullName',
    //         'Email'     => 'Email',
    //         'Address'   => 'Address',
    //         'NIC'       => 'NICNo',
    //         'Photo'     => 'Photo',
    //         'Rate'      => 'Rate'
    //     ];
    //     $this->foreignKeys = [
    //         // 'ParentID'  => 'parenttaskid',
    //         // 'UserID'    => 'userid'
    //     ];
    // }

    # User Table Structure assigned
    public function userStructure()
    {
        $this->table = 'user';
        
        $this->primaryKeys = [
            'UserID'  => 'id'
        ];
        
        $this->allKeys = [
            'UserID'        => 'id',
            'UserSessionID' => 'sessionid',
            'UserContactNo' => 'contactno',
            'Username'      => 'username',
            'Password'      => 'password',
            'UserEmail'     => 'email',
            'UserStatus'    => 'status'
        ];
        
        $this->foreignKeys = [
        ];
    }

    // # Corparation Table Structure assigned
    // public function corparationStructure()
    // {
    //     $this->table = 'corparation';
        
    //     $this->primaryKeys = [
    //         'CorparationID' => 'CorparationID'
    //     ];
        
    //     $this->allKeys = [
    //         'CorparationID' => 'CorparationID',
    //         'Name'          => 'Name',
    //         'Summary'       => 'Summary',
    //         'Description'   => 'Description',
    //         'BIR'           => 'BIR',
    //         'Logo'          => 'Logo',
    //         'Rate'          => 'Rate',
    //         'Status'        => 'Status'
    //     ];
        
    //     $this->foreignKeys = [
    //     ];
    // }

    // # Supplier Table Structure assigned
    // public function supplierStructure()
    // {
    //     $this->table = 'supplier';
        
    //     $this->primaryKeys = [
    //         'SupplierID' => 'SupplierID'
    //     ];
        
    //     $this->allKeys = [
    //         'SupplierID' => 'SupplierID',
    //         'FullName'      => 'FullName',
    //         'About'         => 'About',
    //         'SupplierType'  => 'SupplierType',
    //         'Status'        => 'Status',
    //         'UserID'        => 'UserID',
    //         'CorparationID' => 'CorparationID'
    //     ];
        
    //     $this->foreignKeys = [
    //         // 'UserID'        => 'UserID',
    //         // 'CorparationID' => 'CorparationID',
    //     ];

    // }

    # Screen Map Table Structure assigned
    public function screen_mapStructure()
    {
        $this->table = 'screen_map';
        
        $this->primaryKeys = [
            'ParentCode' => 'parent_code',
            'ScreenCode'  => 'screen_code'
        ];
        
        $this->allKeys = [
            'ParentCode' => 'parent_code',
            'ScreenCode' => 'screen_code',
            'Order'      => 'order'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # Screen Table Structure assigned
    public function screenStructure()
    {
        $this->table = 'screen';
        
        $this->primaryKeys = [
            'ScreenCode'  => 'screen_code',
        ];
        
        $this->allKeys = [
            'ScreenCode'  => 'screen_code',
            'ScreenTitle' => 'screen_title',
            'ScreenURL'   => 'screen_url'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # Stored Text Table Structure assigned
    public function stored_textStructure()
    {
        $this->table = 'stored_text';
        
        $this->primaryKeys = [
            'ScreenCode'  => 'screen_code',
            'StoredText'  => 'stored_text'
        ];
        
        $this->allKeys = [
            'ScreenCode'  => 'screen_code',
            'StoredText'  => 'stored_text'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # Language Table Structure assigned
    public function languageStructure()
    {
        $this->table = 'language';
        
        $this->primaryKeys = [
            'LangCode'  => 'lang_code',
            'LangDesc'  => 'lang_desc'
        ];
        
        $this->allKeys = [
            'LangCode'  => 'lang_code',
            'LangDesc'  => 'lang_desc'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # Stored Text Lang Map Table Structure assigned
    public function stored_text_lang_mapStructure()
    {
        $this->table = 'stored_text_lang_map';
        
        $this->primaryKeys = [
            'StoredText' => 'stored_text',
            'LangCode'   => 'lang_code'
        ];
        
        $this->allKeys = [
            'StoredText' => 'stored_text',
            'LangCode'   => 'lang_code',
            'Values'     => 'values'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # Parameter Table Structure assigned
    public function parameterStructure()
    {
        $this->table = 'parameter';
        
        $this->primaryKeys = [
            'ParameterCode' => 'code'
        ];
        
        $this->allKeys = [
            'ParameterCode' => 'code',
            'DataType'      => 'datatype',
            'Parameter'     => 'value',
            'ParaType'      => 'type'
        ];
        
        $this->foreignKeys = [
        ];
    }
}