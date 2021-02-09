<?php

namespace App\Http\Controllers;

use App\Language;
use App\Translation;
use CodedCell\Repository\Language\LanguageInterface;
use Illuminate\Http\Request;
use CodedCell\Traits\PaginateTrait;

class LanguageController extends Controller
{
    use PaginateTrait;

    public function __construct(LanguageInterface $language)
    {
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
        return view('translation.view_languages');
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $product = $this->language->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($product, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('translation.create_language');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $language = Language::create($request->all());
        $translations = Translation::where('language', 'en')->get();
        foreach ($translations as $translation) {
            $translation->language = $language->language;
            Translation::create(array_except($translation->toArray(),['id','created_at','updated_at']));
        }
        return redirect()->action('LanguageController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
