<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 03/01/15
 * Time: 14:38
 */

namespace App;

use Auth;
use CodedCell\Classes\RandomColor;
use Config;
use File;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use DNS1D;

class Helper
{
    public static function modules()
    {
        return array(
            array('text' => 'Receipt', 'id' => 'Receipt'),
            array('text' => 'Warehouse', 'id' => 'Warehouse'),
            array('text' => 'ProductCategory', 'id' => 'ProductCategory'),
            array('text' => 'UserRoles', 'id' => 'UserRoles'),
            array('text' => 'User', 'id' => 'User'),
            array('text' => 'Supplier', 'id' => 'Supplier'),
            array('text' => 'Staff', 'id' => 'Staff'),
            array('text' => 'Setting', 'id' => 'Setting'),
            array('text' => 'Restock', 'id' => 'Restock'),
            array('text' => 'PurchaseOrder', 'id' => 'PurchaseOrder'),
            array('text' => 'Product', 'id' => 'Product'),
            array('text' => 'Message', 'id' => 'Message'),
            array('text' => 'Invoice', 'id' => 'Invoice'),
            array('text' => 'Dispatch', 'id' => 'Dispatch'),
            array('text' => 'Department', 'id' => 'Department'),
            array('text' => 'Customer', 'id' => 'Customer'),
            array('text' => 'Company', 'id' => 'Company'),
            array('text' => 'SalesOrder', 'id' => 'SalesOrder'),
            array('text' => 'Currency', 'id' => 'Currency'),
            array('text' => 'InvoicePayment', 'id' => 'InvoicePayment'),
            array('text' => 'PurchaseOrder', 'id' => 'PurchaseOrder'),
            array('text' => 'Company', 'id' => 'Company'),
        );
    }

    /**
     * @param $customers
     * @param $list
     * @return array
     */
    public static function selectArray($customers)
    {
        $vals = array();
        foreach ($customers as $key => $value) {
            $list['id'] = $key;
            $list['text'] = $value;
            array_push($vals, $list);
        }
        return json_encode($vals);
    }

    public static function generateColor($hue, $count, $luminosity = 'light')
    {
        return RandomColor::many($count, array(
            'hue' => $hue,
            'luminosity' => $luminosity
        ));
    }

    public static function getPurchaseOrderFormats()
    {
        $directory = Config::get('view.paths')[0] . '/purchaseorder/formats';
        return File::files($directory);
    }

    /**
     * @param $product
     * @return array
     */
    public static function checkIfMultipleStorage($productId)
    {
        $product_status = Product::find($productId);
        $multiple_storage = 0;
        if (isset($product_status)) {
            $multiple_storage = $product_status->usesMultipleStorage;
            return $multiple_storage;
        }
        return $multiple_storage;
    }

    public static function getInfo($ip, $oid, $community = 'public')
    {
        try {
            $info = \snmpget($ip, $community, $oid);
            $info = explode(":", $info);
            $info = str_replace('(', '', $info[1]);
            $info = str_replace('"', '', $info);
            if ($info[0] == "Hex-STRING") {
                return "";
            }
            return trim($info);
        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }


    /**
     * @return string
     * Used to get path to store avatar
     */
    public static function avatar()
    {
        if (Auth::user() && Auth::user()->avatar != null) {
            return url(Storage::url(Auth::user()->avatar));
        } else {
            return url(Storage::url('avatar/placeholder.png'));
        }

    }

    /**
     * Get List of users
     */
    public static function getUser()
    {
        if (Auth::user()) {
            return Auth::user();
        }
    }

    /**
     * @param string $path
     * @return mixed Used to generate download paths
     * Used to generate download paths
     */
    public static function downloadPath($path = '')
    {
        $str = public_path();
        $str = str_replace("\\application\\public", "", $str);
        $str = str_replace('/application/public', "", $str);
        return $str . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public static function paginateQuery(
        $query,
        $count,
        $limit,
        $page,
        $queryString,
        $path
    )
    {
        $paginator = new Paginator($query, $count, $limit, $page, [
            'query' => $queryString
        ]);
        $paginator->setPath($path);
        return $paginator;
        /*
                $paginator = new Paginator($supplier, $this->getSuppliersCount(), env('RECORDS_VIEW'), null, [
                    'query' => $params['sort']
                ]);
                $paginator->setPath('/supplier');
                return $paginator;
        */
    }

    /**
     * @param $data
     * Saves barcode to png
     */
    public static function saveBarcode($data)
    {
        /*
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        */
        $path = storage_path() . '/fucklife.png';
        file_put_contents($path, base64_decode($data));
    }

    public static function fontawesomeArray()
    {
        $path = base_path() . '/public/assets/css/font-awesome.css';
        $class_prefix = 'fa-';
        $pattern = '/\.(' . $class_prefix . '(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        $subject = file_get_contents($path);

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach ($matches as $match) {
            $icons[$match[1]] = $match[1];
        }

        //  $icons = var_export($icons, TRUE);
        //$icons = stripslashes($icons);

        return $icons;
    }


    /**
     * @param $d
     * @return array
     * Converts Query builder data to array
     */
    public static function objectToArray($d)
    {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map([__CLASS__, __METHOD__], $d);
        } else {
            // Return array
            return $d;
        }
    }

    /**
     * @return mixed
     * Used to generate download paths
     */
    public static function downloadPathWithFolder($folder)
    {
        $str = public_path();
        $str = str_replace("\\application\\public", "", $str);
        $str = str_replace('/application/public', "", $str);
        return $str . "/" . $folder;
    }

    /**
     * @param $englishWord
     * @param $file
     * @param $limit
     * @param string $placement
     * @return string
     * Use as Below
     *  {!! \App\Helper::translateAndShorten('test','dashboard',2,'top')!!}
     */
    public static function translateAndShorten($englishWord, $file, $limit, $placement = 'top')
    {
        $translationFile = $file . '.' . $englishWord;
        $translation = trans($translationFile);
        if (strlen($translation) > 12) {
            return '<span class="translate" data-toggle="tooltip" data-placement="' . $placement . '" title="' . $translation . '" >' . str_limit($translation, $limit) . '</span>';

        }
        return $translation;
    }

    public static function popover($title, $content)
    {

        return 'data-container="body" data-toggle="popover" title="' . $title . '" data-content="' . $content . '" trigger="hover"';
    }

    public static function checked($size)
    {
        $page = Setting::firstOrCreate(['userId' => Auth::user()->id]);
        if ($page->paginationDefault == $size) {
            return 'checked=true';
        }
    }

    public static function sendSms($type, $invoice, $dueAmount = 0, $payment = 0)
    {
        $items = array();
        foreach ($invoice->items as $item) {
            array_push($items, $item->productDescription);
        }
        $string = implode(",", $items);
        $date = Carbon::today()->format('Y-m-d');
        $template = array(
            'payment' => "Your payment of {$invoice->currencyTypeText} {$payment} has been accepted. Your current due amount is {$invoice->currencyTypeText} $dueAmount",
            'payment_reminder' => "Please pay your outstanding amount to avoid late payment charges and uninterrupted service",
            'delivery' => "Your order for {$string} Has been delivered on {$date}. Your current due amount is {$dueAmount}"
        );
        $sms_url = env('SMS_URL');

        $sms_arr = array('AUTH_KEY' => env('SMS_AUTH_KEY'), 'message' => urldecode($template[$type]),
            'senderId' => env('SMS_SENDERID'), 'routeId' => '1', 'smsContentType' => 'english',
            'mobileNos' => '9990378883');

        $querystring = http_build_query($sms_arr);

        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $sms_url, [
                'query' => $querystring
            ]);
            echo $res->getStatusCode();
            echo $res->getBody();

        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            echo $response;
        }

    }

    public static function miniLabel($product)
    {
        $path = DNS1D::getBarcodePNGPath($product->barcode, "UPCA", $w = 3, $h = 100);
        $string = 'app/public/barcodes/template.jpg';
        $filePath = storage_path($string);
        $img = imagecreatetruecolor(400, 230);
        $bg = imagecolorallocate($img, 255, 255, 255);
        imagefilledrectangle($img, 0, 0, 400, 300, $bg);
        imagejpeg($img, $filePath, 100);
        $img = Image::make($filePath);
        $img->text($product->productName, 200, 10, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });
        $expiry = 'Exp Date:' . $product->expiryDate;
        $img->text($expiry, 370, 10, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(20);
            $font->color('#edc257');
            $font->align('right');
            $font->valign('top');
            $font->angle(90);
        });
        $price = $product->sellingPrice . ' ' . $product->productCurrency;
        $img->text($price, 200, 40, function ($font) {
            $font->file(public_path('fonts/Chunkfive.otf'));
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });
        $img->text($product->barcode, 200, 180, function ($font) {
            $font->file(public_path('fonts/CaviarDreams_Italic.ttf'));
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });
        $img->insert(public_path($path), 'center');
        File::delete(public_path($path));
        $path = 'storage/barcodes/' . $product->barcode . '.jpg';
        $img->save(public_path($path));
    }

    public static function labelDetailsHelper($product, $warehouse = null)
    {
        $product->barcode = $warehouse->productBarcode;
        self::labelDetails($product, $warehouse);
    }

    public static function UPC_checkdigit($str)
    {
        $digit = 0;
        if (!preg_match('/^[0-9]{11,12}$/', $str)) return;
        for ($i = 0; $i <= 10; $i++) {
            $digit += $str[$i] * (!fmod($i, 2) ? 3 : 1);
        }
        $digit = substr(500 - $digit, -1);
        if (strlen($str) == 12) {
            return $digit == substr($str, -1);
        } else {
            return $digit;
        }
    }

    public static function generateBarcode()
    {
        $number = rand($min = 10000000000, $max = 100000000000);
        $digit = self::UPC_checkdigit((string)$number);
        return $number . $digit;
    }

    public static function labelDetails($product, $warehouse = null)
    {
        $path = DNS1D::getBarcodePNGPath($product->barcode, "C93", $w = 5, $h = 100);
        $path2 = DNS1D::getBarcodePNGPath($product->hash, "C93", $w = 4, $h = 80);
        $string = 'app/public/barcodes/template2.jpg';
        $filePath = storage_path($string);
        $img = imagecreatetruecolor(830, 600);
        $bg = imagecolorallocate($img, 255, 255, 255);
        imagefilledrectangle($img, 0, 0, 830, 600, $bg);
        imagejpeg($img, $filePath, 100);
        $img = Image::make($filePath);
        $img->text($product->productName, 415, 10, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(40);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });

        $expiry = 'Exp Date:' . $product->expiryDate;
        $img->text($expiry, 780, 10, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(40);
            $font->color('#edc257');
            $font->align('right');
            $font->valign('top');
            $font->angle(90);
        });
        $price = $product->sellingPrice . ' ' . $product->productCurrency;
        $img->text($price, 415, 70, function ($font) {
            $font->file(public_path('fonts/Chunkfive.otf'));
            $font->size(40);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });

        $sn = 'SN : ' . $product->productSerial;

        $img->text($sn, 415, 120, function ($font) {
            $font->file(public_path('fonts/Lato-Light.ttf'));
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });
        $weight = 'Weight : ' . $product->productWeight . ' ' . $product->productMeasurementUnit;
        $img->text($weight, 650, 210, function ($font) {
            $font->file(public_path('fonts/Lato-HeavyItalic.ttf'));
            $font->size(30);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });

        $manufacturer = 'Manufacturer : ' . $product->productManufacturer;
        $img->text($manufacturer, 400, 390, function ($font) {
            $font->file(public_path('fonts/Lato-HeavyItalic.ttf'));
            $font->size(30);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });
        if (isset($warehouse)) {

            $warehouse_name = 'Warehouse : ' . $warehouse->productLocationName;
            $img->text($warehouse_name, 100, 180, function ($font) {
                $font->file(public_path('fonts/Lato-Bold.ttf'));
                $font->size(20);
                $font->color('#000');
                $font->align('center');
                $font->valign('top');
                $font->angle(0);
            });
            $bin = 'Bin : ' . $warehouse->binLocationName;
            $img->text($bin, 100, 210, function ($font) {
                $font->file(public_path('fonts/Lato-Bold.ttf'));
                $font->size(20);
                $font->color('#000');
                $font->align('center');
                $font->valign('top');
                $font->angle(0);
            });

        }
        $img->text($product->barcode, 585, 565, function ($font) {
            $font->file(public_path('fonts/CaviarDreams_Italic.ttf'));
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });
        $img->text($product->hash, 250, 235, function ($font) {
            $font->file(public_path('fonts/CaviarDreams_Italic.ttf'));
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });


        $img->insert(public_path($path), 'bottom-right', 10, 40);
        $img->insert(public_path($path2), 'left', 10, 0);
        File::delete(public_path($path));
        File::delete(public_path($path2));
        $path = 'storage/barcodes/l' . $product->barcode . '.jpg';
        $img->save(public_path($path));
    }
}