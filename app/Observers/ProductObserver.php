<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 20:19
 */

namespace App\Observers;

use App\Helper;
use App\StockAudit;
use Hashids\Hashids;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Image;
use DNS1D;


class ProductObserver
{


    public function audit(Product $product, $status)
    {
        $narration = '';
        $username = "System";
        if (Auth::check()) {
            $username = Auth::user()->name;
        }
        StockAudit::create(array(
            'oldValues' => serialize(array_only($product->getOriginal(), array_keys($product->getDirty()))),
            'newValues' => serialize($product->getDirty()),
            'stockOperation' => $status,
            'narration' => $narration,
            'productId' => $product->id,
            'username' => $username
        ));
    }

    /**
     * Listen to the Product created event.
     *
     * @param  Product $product
     * @return void
     */
    public function created(Product $product)
    {
        $this->audit($product, 'Product Created');
        $hashids = new Hashids('', 8);
        $product->hash = $hashids->encode($product->id, rand(1, 2000));
        $product->save();
    }


    public function updating(Product $product)
    {
        $this->audit($product, 'Product Updated');
    }

    public function saved(Product $product)
    {
        if ($product->barcode != null or $product->barcode != "") {
            Helper::miniLabel($product);
            Helper::labelDetails($product);
        }
    }

    /**
     * Listen to the Product deleting event.
     *
     * @param  Product $product
     * @return void
     */
    public function deleting(Product $product)
    {
        //
    }


    /**
     * Listen to the Product deleting event.
     *
     * @param  Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }
}