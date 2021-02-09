<?php

namespace App\Http\Controllers;

use App\ProductLocation;
use CodedCell\Repository\Product\ProductInterface;

class ProductLocationController extends Controller
{
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
        $this->middleware('auth');
    }

    public function deleteProductLocation($id)
    {
        $item = ProductLocation::where('hash', $id);
        $item->delete();
    }
}
