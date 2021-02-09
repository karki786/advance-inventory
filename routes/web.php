<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

foreach (File::allFiles(__DIR__ . '/Routes') as $partial) {
    require (string)$partial;
}
Auth::routes();

Route::get('/home', 'HomeController@index');

#customer Login
Route::post('customer/auth/logmein', 'Auth\CustomerLoginController@login');
Route::get('customer/auth/login', 'Auth\CustomerLoginController@showLogin');
Route::get('cust/', 'CustomerFrontendController@index');
Route::get('cust/quotations', 'CustomerFrontendController@quotations');
Route::get('cust/quotations/{orderNo}', 'CustomerFrontendController@viewQuotation');
Route::get('cust/quotations/approve/{orderNo}', 'CustomerFrontendController@approveQuotation');
Route::get('cust/invoice/{invoiceNumber}', 'CustomerFrontendController@viewInvoice');
Route::get('cust/invoice/pay/{invoiceNumber}', 'CustomerFrontendController@payInvoice');
Route::get('cust/logout', 'Auth\CustomerLoginController@logout');


HTML::macro('current', function () {
    $Routes = func_get_args();
    $HTML = ' class=active';
    $hover = array_rand(['hvr-sweep-to-right' => 'hvr-sweep-to-right'], 1);
    $hover = 'class=' . $hover;
    foreach ($Routes as $route):

        if (Request::is($route)) {
            return $HTML;
        } elseif (str_contains($route, '*')) {
            $fallback = str_replace("/*", "", $route);
            if (Request::url() == url($fallback)) {
                return $HTML;
            }

        } else {
            return $hover;
        }
    endforeach;
});

HTML::macro('currentHeader', function () {
    $Routes = func_get_args();
    $HTML = ' class=active';
    $hover = array_rand(['hvr-sweep-to-bottom' => 'hvr-sweep-to-bottom'], 1);
    $hover = 'class=' . $hover;
    foreach ($Routes as $route):
        if (Request::is($route)) {
            return $HTML;
        } else {
            return $hover;
        }
    endforeach;
});

HTML::macro('sort', function ($controller, $column, $body, $translationFile = 'stockitems') {
    $direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
    $sort = (Request::get('direction') == 'asc') ? 'sort-desc' : 'sort-asc';
    return link_to_action($controller, trans(strval($translationFile) . '.' . str_limit($body, 20)), ['sortBy' => $column, 'direction' => $direction], ['class' => $sort . ' translate', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => $body]);
}
);


