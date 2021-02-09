<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\ProductCategory;
use Carbon\Carbon;
use CodedCell\Repository\Category\CategoryInterface;
use Illuminate\Http\Request;
use Redirect;
use Response;
use Excel;
use CodedCell\Traits\PaginateTrait;

class CategoryController extends Controller
{
    use PaginateTrait;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('glance', ProductCategory::class);
        return View('category/view_categories');
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->category->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ProductCategory::class);
        return view('category/create_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', ProductCategory::class);
        $category = $this->category->create($request->all());
        return Redirect::action('CategoryController@show', $category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = $this->category->find($id);
        $this->authorize('view', $categories);
        return view('category/view_category')->with(compact('categories', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        $this->authorize('view', $category);
        return view('category/create_category')->with(compact('category'));
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
        $this->category->update($request->all(), $id);
        return Redirect::action('CategoryController@show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->delete($id);
        return Response::json(['ok' => 'ok']);
    }

    public function export(Request $request)
    {
        $format = $request->type;
        $filename = Carbon::now()->format('Ymd_') . "Category";
        $file = Excel::create($filename, function ($excel) {

            $excel->sheet('Categories and Products', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('potrait');
                $categories = $this->category->all();
                $sheet->loadView('reports.category_report.categories')->with(compact('categories'));

            });


        });

        if ($format == "email") {
            $email = $request->email;
            $save_details = $file->store('xlsx');
            $message = "Please find attached a list of products and their levels";
            $reportName = "Product Levels Report";
            $variables = array(
                'content' => $message,
                'reportName' => $reportName,
                'staff' => "Dennis Wanyoike",
                'action' => 'Blah'

            );
            Mail::send('emails.report_view', $variables, function ($message) use ($save_details, $email) {
                $message->to($email)->subject('Products And Their Levels in Stock Control System');
                $message->attach($save_details['full']);
            });
            return Response::json(['ok' => 'ok']);
        } else {
            $file->download($format);
        }
    }
}
