<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('', 'Home::index');

// Account informations
$routes->get('/account/list', 'AccountController::accountList');
$routes->get('/account/add', 'AccountController::addAccount');
$routes->get('/account/change', 'AccountController::changeAccount');
$routes->get('/budget/add', 'AccountController::addBudget');
$routes->get('/transaction/add', 'TransactionController::createTransaction');
$routes->get('/account/info/(:any)', 'AccountController::accountPage/$1');
// $routes->get('/account/remove-budget/(:any)', 'AccountController::deleteBudget/$1');
$routes->post('/js-request/account/create', 'AccountController::createAccount');
$routes->post('/js-request/account/update', 'AccountController::updateAccount');
$routes->post('/js-request/account/delete', 'AccountController::deleteAccount');
$routes->post('/js-request/budget/create', 'AccountController::createBudget');
$routes->post('/js-request/budget/update', 'AccountController::updateBudget');
$routes->post('/js-request/budget/delete', 'AccountController::deleteBudget');

// Transaction information
$routes->get('/transaction/list', 'AccountController::transactionList');
$routes->post('/js-request/account/transferred', 'AccountController::internalTransaction');
$routes->post('/js-request/payment/expense', 'PurchaseController::expenseTransaction');
$routes->post('/js-request/payment/purchase', 'PurchaseController::purchaseTransaction');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
