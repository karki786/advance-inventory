<?php

namespace App\Http\Controllers;

use App\Country;
use App\Company;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Input;
use File;
use Response;
use App\Http\Requests\CompanyRequestForm;

class CompanyController extends Controller
{
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
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id, CompanyRequestForm $requestForm)
    {
        Company::find($id)->update($request->all());
        return redirect()->back();
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

    public function uploadLogo(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file->move(storage_path("app/logo/"), "logo.{$extension}");
            Company::find($request->id)->update(array('logo' => "logo.{$extension}"));
            return ["logo.{$extension}"];
        }
    }

    public function getLogo($filename)
    {
        $path = storage_path() . '/app/logo/' . $filename;
        if (!File::exists($path)) abort(404);
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function uploadFavicon(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file->move(storage_path("app/favicon/"), "favicon.ico");
        }
    }
}
