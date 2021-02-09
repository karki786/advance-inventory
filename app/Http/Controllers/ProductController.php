<?php namespace App\Http\Controllers;


use App\Helper;
use App\Http\Requests\ProductFormRequest;
use App\Http\Requests\UploadFormRequest;
use App\Product;
use App\ProductPhotos;
use CodedCell\Repository\Product\ProductInterface;
use DNS1D;
use DNS2D;
use Excel;
use Flash;
use Illuminate\Http\Request;
use Image;
use Mail;
use PDF;
use Redirect;
use Response;
use Schema;
use DB;
use CodedCell\Traits\PaginateTrait;

class ProductController extends Controller
{
    use PaginateTrait;

    /**
     * Constructor for Products
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //dd(public_path('storage/barcodes/template.jpg'));
        $this->authorize('glance', Product::class);

        return View('products/view_products');
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $product = $this->product->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($product, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        return View('products/create_product')->with(compact('products', 'serials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, ProductFormRequest $validate)
    {
        $this->authorize('create', Product::class);
        $product = $this->product->create($request->except(array('locations', 'whsName', 'products', 'locs')), $request->locations);
        return Redirect::action('ProductController@show', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $product = $this->product->find($id);
        //dd($product->restocks->pluck('amount'));
       // dd($product->restocks->pluck('created_at'));
        $this->authorize('view', $product);
        return view('products/view_product')->with(compact('product', 'html'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::with(['photos', 'restocks', 'dispatches', 'locations' => function ($query) {
            $query->select('hash', 'productId', 'productLocation', 'productLocationName', 'binLocation', 'binLocationName', 'productBarcode', 'unitCost', 'productCurrency', 'sellingPrice', DB::raw('sum(amount) as amount'));
            $query->groupBy('hash');
        }])->findOrFail($id);
        // $product = $this->product->find($id);
        $this->authorize('update', $product);
        $gridData = array();
        if ($product->locations) {
            $gridData = json_encode($product->locations);
        }

        return View('products/create_product')->with(compact('product', 'products', 'serials', 'gridData'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id, ProductFormRequest $validate)
    {
        $this->product->update($request->except('locations', 'whsName', 'products', 'locs'), $request->locations, $id);
        return Redirect::action('ProductController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
        $this->authorize('delete', $product);
        $this->product->delete($id);
        return Response::json(['ok' => 'ok']);
    }

    public function barcode($id)
    {
        $generator = new BarcodeGeneratorJPG();
        $jpg = $generator->getBarcode($id, $generator::TYPE_CODE_128, 4, 100);
        $img = Image::make($jpg);
//        $logo = Image::canvas(800, 600);
//        $logo->text('The quick brown fox jumps over the lazy dog.',0,100);
//        $img->insert($logo,'bottom');
        return response($img->encode('jpg'), 200)->header('Content-Type', 'image/jpeg');
    }

    public function downloadPath($path = '')
    {
        $str = public_path();
        $str = str_replace("\\application\\public", "", $str);
        $str = str_replace('/application/public', "", $str);
        return $str . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get a filename for the file.
     *
     * @param  string $path
     * @return string
     */
    public function hashName($path = null)
    {
        if ($path) {
            $path = rtrim($path, '/') . '/';
        }
        $hash = $this->hashName ?: $this->hashName = Str::random(40);
        return $path . $hash . '.' . $this->guessExtension();
    }

    /**
     * Uploads a new photo
     * @param $id
     * @return array
     */
    public function uploadPhoto($id, Request $request)
    {
        if ($request->hasFile('file')) {
            $product_image = $request->file('file');
            $hash = str_random(40);
            $filename = $hash . '_50.' . $request->file('file')->guessExtension();
            $string = 'app/public/products/' . $filename;
            $filePath = storage_path($string);
            Image::make($request->file('file'))->resize(80, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($filePath);
            $photo = ProductPhotos::create(array(
                'filepath' => $filePath,
                'filename' => $filename,
                'pictureWidth' => 80,
                'pictureHeight' => 500,
                'pictureType' => $request->file('file')->getMimeType(),
                'isThumbnail' => 1,
                'productId' => $id
            ));
            $widths = array(50, 100, 200, 400, 600, 800, 100, 1200, 1400);
            foreach ($widths as $width) {
                $filename = $hash . '_' . $width . '.' . $request->file('file')->guessExtension();
                $string = 'app/public/products/' . $filename;
                $filePath = storage_path($string);
                Image::make($request->file('file'))->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($filePath);
                $photo = ProductPhotos::create(array(
                    'filepath' => $filePath,
                    'filename' => $filename,
                    'pictureWidth' => $width,
                    'pictureHeight' => 500,
                    'pictureType' => $request->file('file')->getMimeType(),
                    'isThumbnail' => 0,
                    'productId' => $id
                ));
            }

            return $photo;
        }
    }


    public function import(Request $request)
    {
        $columns = Schema::getColumnListing('products');
        unset($columns[0]);
        unset($columns[15]);
        unset($columns[16]);
        unset($columns[17]);
        unset($columns[34]);
        unset($columns[34]);
        unset($columns[35]);
        unset($columns[36]);
        unset($columns[37]);
        unset($columns[38]);
        unset($columns[39]);
        unset($columns[30]);
        $columns = array_except($columns, 'companyId', 'usesmultiplestorage', 'updatedBy', 'createdBy', 'deleted_at', 'created_at', 'updated_at');
        if ($request->has('download')) {
            $this->dataTransfer();
        }
        return View('products/import')->with(compact('columns'));
    }

    /**
     * Downloads Data Transfer Workbench File
     */
    public function dataTransfer()
    {
        $file = Excel::create("Data Transfer WorkBench", function ($excel) {

            // Set the title
            $excel->setTitle('Data Transfer WorkBench');

            // Chain the setters
            $excel->setCreator('Stock Control System')
                ->setCompany(env('COMPANY_NAME'));

            // Call them separately
            $excel->setDescription('Data Transfer Workbench');
            $excel->sheet('Data Transfer Workbench', function ($sheet) {
                $sheet->freezeFirstRowAndColumn();
                $columns = Schema::getColumnListing('products');
                unset($columns[0]);
                unset($columns[15]);
                unset($columns[16]);
                unset($columns[17]);
                unset($columns[34]);
                unset($columns[34]);
                unset($columns[35]);
                unset($columns[36]);
                unset($columns[37]);
                unset($columns[38]);
                unset($columns[39]);
                unset($columns[30]);

                $sheet->fromArray($columns);
            });
        });
        $file->download();
    }

    public function uploadData(Request $request, UploadFormRequest $form)
    {

        $file = $request->file('workbenchfile');

        Excel::load($file, function ($reader) {
            $results = $reader->toArray();
            foreach ($results as $result) {
                $result["usesMultipleStorage"] = 0;
                $this->product->create($result, null);
            }
        });
        //return Redirect::action('ProductController@index');
    }

    public function getLocation(Request $request, $id)
    {
        if (count($this->product->getWarehouseLocationDetailsForGrid($id)) > 0) {
            return (array)$this->product->getWarehouseLocationDetailsForGrid($id)[0];
        } else {
            return array();
        }

    }
}
