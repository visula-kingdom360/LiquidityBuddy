<?php

namespace App\Controllers;

class SupplierController extends MainController
{
    public function errorPage()
    {
        echo view('errors/errorpage'); //.php optional
    }
}