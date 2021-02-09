<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Helper;
use App\ModulePermission;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = ['password.regex' => "Your password must contain 1 lower case character 1 upper case character one number"];
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed|regex:/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            'companyName' => 'required_without:companyneeded|min:3',
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        if (env('DISABLE_REGISTRATION', false) == true) {
            $companyId = env('DEFAULT_COMPANY_REGISTRATION', 1);
            $roleId = Role::firstOrCreate(
                array(
                    'name' => 'Guest',
                    'description' => 'For Guest Logins'
                )
            );
            $roleId = $roleId->id;
            $verified = 0;
        } else {
            $company = Company::create(array(
                'companyName' => $data['companyName'],
                'purchaseOrderFormat' => 'sales_order_1',
                'lpoNumberingFormat' => 'LPO-{$year}/{$month}/{$date}/{$lpoNumber}'
            ));
            $companyId = $company->id;
            $role= Role::firstOrCreate(
                array(
                    'name' => 'Setup Admin',
                    'description' => 'Initial Role For use for StockAwesome Setups'
                )
            );
            $roleId = $role->id;
            $verified = 1;
            if (count($role->permissions) < 1) {
                foreach (Helper::modules() as $model) {
                    ModulePermission::updateOrCreate(
                        [
                            'roleId' => $roleId,
                            'model' => $model['text']
                        ],
                        [
                            'canCreate' => 1,
                            'canGlance' => 1,
                            'canView' => 1,
                            'canUpdate' => 1,
                            'canDelete' => 1,
                        ]
                    );
                }
            }

        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'companyId' => $companyId,
            'role_id' => $roleId,
            'verified' => $verified
        ]);
        if (env('DISABLE_REGISTRATION', false) == true) {
            $admins = User::where('companyId', $companyId)->where('role_id', 1)->select('email')->get()->toArray();
            Mail::to($admins)->send(new UserRegistered($user));
        }
        return $user;
    }
}
