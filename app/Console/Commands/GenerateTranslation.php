<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Dedicated\GoogleTranslate\Translator;
use Excel;
use App\Language;
use App\Translation;
use Illuminate\Foundation\Application as pth;
use File;
use View;

class GenerateTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(pth $ph)
    {
        $translator = new Translator();
        $languages = array('de', 'es', 'fr', 'in', 'nl', 'pt', 'ru', 'en');
        $file = 'Translations/Trans_Doc.xlsx';

        foreach ($languages as $language) {
            Excel::load($file, function ($reader) use ($language, $translator) {
                $results = $reader->toArray();
                foreach ($results as $result) {
                    $lang = Language::withoutGlobalScopes()->firstOrCreate(array(
                        'language' => $language
                    ));
                    if ($language == 'en') {
                        $translated = $result['orig_lang'];
                    } else {
                        $inDB = Translation::withoutGlobalScopes()
                            ->where('language', $language)
                            ->where('module', $result['module'])
                            ->where('orig_lang', trim($result['orig_lang']))
                            ->first();
                        if(count($inDB)>0){
                            $translated = $inDB->trans_lang;
                            $this->info("Already Translated To {$translated}");
                        }else{
                            $translated = $translator->setSourceLang('en')
                                ->setTargetLang($language)
                                ->translate(trim($result['orig_lang']));
                            $temp = trim($result['orig_lang']);
                            $this->info("Translated {$temp}");
                        }

                    }

                    Translation::withoutGlobalScopes()->firstOrcreate(array(
                        'module' => $result['module'],
                        'language' => $language,
                        'orig_lang' => trim($result['orig_lang']),
                        'trans_lang' => trim(htmlentities($translated)),
                        'languageId' => $lang->id
                    ));
                }
            });
        }

        $languages = Language::withoutGlobalScopes()->get();

        foreach ($languages as $language) {
            //Mkdir Language
            if (!File::exists($ph->langPath() . '/' . $language->language)) {
                File::makeDirectory($ph->langPath() . '/' . $language->language);
            }
            $translations = Translation::select('orig_lang', 'trans_lang', 'module')->where('languageId', $language->id)->get();
            $modules = $translations->groupBy('module');
            foreach ($modules as $key => $module) {
                //mk File
                $html = View::make('layouts.lang', compact('module'))->render();
                $file = $ph->langPath() . '/' . strtolower($language->language) . '/' . strtolower($key) . '.php';
                $bytes_written = File::put($file, $html);
            }
        }


    }
}
