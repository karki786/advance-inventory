<?php namespace App\Http\Controllers;

use App\Company;
use App\Country;
use App\Http\Requests;
use Auth;
use CodedCell\Repository\Settings\SettingsInterface;
use Input;
use Redirect;
use App\Helper;

class SettingController extends Controller
{
    /**
     * @var SettingsInterface
     */
    private $setting;

    /**
     * @param SettingsInterface $setting
     */
    function __construct(SettingsInterface $setting)
    {
        $this->setting = $setting;
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

        $settings = $this->setting->getSettings();
        $this->authorize('view', $settings);
        $company = Company::find(Auth::user()->companyId);
        $countries = Country::all()->pluck('country', 'country');
        $currency = Country::all()->pluck('currency', 'currency');
        return view('settings/userSettings')->with(compact('settings', 'currency', 'countries', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $this->setting->setSettings(Input::except(['_method', '_token']));
        return Redirect::action('SettingController@edit', array(Auth::user()->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function updateAjax($id)
    {
        $this->setting->setSettings(Input::except(['_method', '_token']));
        return response()->json('okay');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function createSymlink()
    {
        //Create Shortcuts in both root and Public Folder
        symlink(storage_path('app/public'), Helper::downloadPath('storage'));
        symlink(storage_path('app/public'), public_path('storage'));
        return array('ok');
    }
}
