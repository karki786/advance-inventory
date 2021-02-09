<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Language;
use App\Translation;
use CodedCell\Repository\Language\LanguageInterface;
use CodedCell\Repository\Translation\TranslationInterface;
use Illuminate\Http\Request;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Illuminate\Foundation\Application as pth;
use File;
use View;

class TranslationController extends Controller
{
    use PaginateTrait;

    public function __construct(TranslationInterface $translation, LanguageInterface $language)
    {
        $this->translation = $translation;
        $this->language = $language;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('translation.view_translations');
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $product = $this->translation->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($product, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = array_unique(array_flatten(Helper::modules()));
        $modules_arr = array();
        foreach ($modules as $module) {
            $modules_arr[$module] = $module;
            $modules_arr['Sidebar'] = 'Sidebar';
            $modules_arr['Category'] = 'Category';
        }
        $modules = $modules_arr;
        return view('translation.upload_translation')->with(compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->translation->create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $language = $this->language->find($id)->language;
        $translations = Translation::where('languageId', $id)->get();
        $modules = array_unique(array_flatten(Helper::modules()));
        $modules_arr = array();
        foreach ($modules as $module) {
            $modules_arr[$module] = $module;
            $modules_arr['Sidebar'] = 'Sidebar';
        }
        $modules = $modules_arr;
        return view('translation.create_translation')->with(compact('id', 'translations', 'modules', 'language'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $translation = $this->translation->find($id);
        $language = $translation->language;
        $modules = array_unique(array_flatten(Helper::modules()));
        $id = $translation->languageId;
        $modules_arr = array();
        foreach ($modules as $module) {
            $modules_arr[$module] = $module;
            $modules_arr['Sidebar'] = 'Sidebar';
            $modules_arr['Category'] = 'Category';
        }
        $modules = $modules_arr;
        return view('translation.create_translation')->with(compact('modules', 'translation', 'language', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->translation->update($request->all(), $id);
        return redirect()->action('TranslationController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(Request $request)
    {
        $file = $request->file('files');
        $module = $request->module;

        Excel::load($file, function ($reader) use ($module) {
            $results = $reader->toArray();
            foreach ($results as $result) {
                //dd($result['en']);
                $english = $result['en'];
                // unset($result['en']);
                foreach ($result as $key => $item) {
                    $lang = Language::firstOrCreate(array(
                        'language' => $key
                    ));
                    Translation::firstOrcreate(array(
                        'module' => $module,
                        'language' => $key,
                        'orig_lang' => trim($english),
                        'trans_lang' => trim(htmlentities($item)),
                        'languageId' => $lang->id
                    ));

                }
            }
        });
    }

    public function compile(pth $ph)
    {
        $languages = $this->language->all();

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
        return redirect()->back();
    }
}
