<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Product;
use App\ProductPhotos;
use CodedCell\Repository\Product\ProductInterface;
use File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->find($id);
        $photos = $product->photos()->where('pictureWidth', 800)->get();
        foreach ($photos as $photo) {
            $photo->url = url(Storage::url('products/' . $photo->filename['filename']));
        }
        return $photos;
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
        ProductPhotos::whereProductid($id)->whereIsthumbnail(1)->update(array('isThumbnail' => 0));
        ProductPhotos::whereId(Input::get('itemId'))->update(array('isThumbnail' => 1));
        ProductPhotos::whereProductid($id)->update(
            array(
                'caption' => Input::get('caption'),
                'title' => Input::get('title')
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photos = ProductPhotos::wherePhotohash($id)->get();
        foreach ($photos as $photo) {
            $destinationPath = Helper::downloadPath() . '/products/' . $photo->filename['filename'];
            File::delete($destinationPath);
        }
        ProductPhotos::wherePhotohash($id)->delete();
    }
}
