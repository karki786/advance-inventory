<?php namespace App\Http\ViewComposers;


use App\Company;
use CodedCell\Repository\Settings\SettingsInterface;
use CodedCell\Repository\User\UserInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Input;

class SettingsComposer
{

    /**
     * @var SettingsInterface
     */
    private $setting;


    public function __construct(SettingsInterface $setting, UserInterface $userInterface)
    {
        $this->setting = $setting;
        $this->user = $userInterface;
    }

    public function compose(View $view)
    {
        $settings = $this->setting->getSettings();
        $companySettings = Company::findOrFail(Auth::user()->companyId);
        $view->with('theme', $settings->appTheme);
        $view->with('homepage', $companySettings->homepage);
        $view->with('barColor', json_encode($settings->barGraphdefaultColor));
        $view->with('settingid', $settings->id);
        $view->with('paginationSize', $settings->paginationDefault);
        $view->with('setting', $settings);
        $view->with('companySettings', $companySettings);
        $view->with('def_currency', $companySettings->defaultCurrency);
        $view->with('enableBeta', $companySettings->enableBetaFeatures);
        $view->with('enableStaffDispatch', $companySettings->enableStaffDispatch);
        $view->with('users', $this->user->all(array())->pluck('name', 'id'));
        $view->with('logo', action('CompanyController@getLogo', $companySettings->logo));
        $view->with('defaultCurrency', action('CompanyController@getLogo', $companySettings->defaultCurrency));
    }


}