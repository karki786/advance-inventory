<?php namespace CodedCell\Repository\Settings;

use App\Setting;
use Auth;

class SettingsEntity implements SettingsInterface
{
    /**
     * Gets black,cyan,magenta,yellow color
     * @return mixed
     */
    public function getLineColors()
    {
        $user = Auth::user();
        if ($user) {
            return Setting::select(
                'blackColor',
                'magentaColor',
                'cyanColor',
                'yellowColor'
            )->where('userId', '=', $user->id)->get()->toArray();
        }

    }

    /**
     * Get Settings for a user
     * @return mixed
     */
    public function getSettings()
    {
        $user = Auth::user();
        if (isset($user)) {
            return Setting::firstOrCreate(['userId' => $user->id]);
        }

    }

    /**
     * Set settings for a user
     * @param $settings
     * @return mixed
     */
    public function setSettings($data)
    {
        $user = Auth::user();
        if (isset($user)) {
            $settings = Setting::where('userId', '=', $user->id);
            if (Auth::user()->can('update', $settings)) {
                return $settings->update($data);
            }

        }

    }
}