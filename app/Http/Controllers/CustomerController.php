<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests;
use App\Http\Requests\CustomerFormRequest;
use Carbon\Carbon;
use CodedCell\Repository\Customer\CustomerInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Illuminate\Http\Request;
use Input;
use PDF;
use Response;

class CustomerController extends Controller
{
    use PaginateTrait;

    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('glance', Customer::class);
        $customers = $this->customer->all();
        return view('customer/view_customers')->with(compact('customers'));

    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->customer->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Customer::class);
        $password = str_random(6);
        return view('customer/create_customer')->with(compact('password'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, CustomerFormRequest $formRequest)
    {
        $this->authorize('create', Customer::class);
        $customer = $this->customer->create($request->except('contacts'), $request->contacts);

        return redirect()->action('CustomerController@show', array('id' => $customer->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customer->find($id);
        $this->authorize('view', $customer);
        return view('customer.view_customer')->with(compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customer->find($id);
        $this->authorize('update', $customer);
        if ($customer->contacts) {
            $contacts = $customer->contacts;
        } else {
            $customer->contacts = null;
        }
        if ($customer->password != null or $customer->password != '') {
            $password = '';
        }
        return view('customer/create_customer')->with(compact('customer', 'contacts', 'password'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id, CustomerFormRequest $formRequest)
    {
        $this->customer->update($request->except('contacts'), json_decode($request->contacts), $id);
        return redirect()->action('CustomerController@show', array('customer' => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->customer->delete($id);
        return Response::json(['ok' => 'ok']);
    }

    /**
     * Get Customer Companies Contacts
     */
    public function getContacts(Request $request)
    {
        return $this->customer->getContacts($request->id);
    }

    /**
     * Gets Deleted Items
     */
    public function getDeleted()
    {
        $customers = $this->customer->all(array('*'), 'deletions');
        $restore = 1;
        return view('customer/view_customers')->with(compact('customers', 'restore'));
    }

    /**
     * Restore Deleted Customer
     * @param $id
     */
    public function restore($id)
    {
        Customer::withTrashed()->find($id)->restore();
        return redirect()->action('CustomerController@show', array('customer' => $id));
    }

    public function getOpenItems($id)
    {
        $customer = Customer::with('orders')->with('invoices')->whereSecret($id)->first();
        return view('customer.customer_view')->with(compact('customer'));
    }

    public function getStatement($id)
    {
        $customer = $this->customer->find($id);
        $pdf = PDF::loadView('reports.customers.statement', compact('customer'));
        return $pdf->download('Customer Statement of Account.pdf');
    }

    public function getReport()
    {
        $format = Input::query('type');
        $filename = Carbon::now()->format('Ymd_') . "Sales Orders";
        $file = Excel::create($filename, function ($excel) {

            $excel->sheet('Customers Ordered by Input', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $customers = $this->customer->all(array('*'));
                $sheet->loadView('reports.customers.report')->with(compact('customers'));

            });

            $excel->sheet('Deleted', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $customers = $this->customer->all(array('*'), 'deletions');
                $sheet->loadView('reports.customers.report')->with(compact('customers'));

            });


        });

        if ($format == "email") {
            $email = Input::get('email');
            $save_details = $file->store('xlsx');
            $content = "Please find attached a list of products and their levels";
            Mail::send('emails.master', array('content' => $content), function ($message) use ($save_details, $email) {
                $message->to($email)->subject('Products And Their Levels in Stock Control System');
                $message->attach($save_details['full']);
            });
            return Response::json(['ok' => 'ok']);
        } else {
            $file->download($format);
        }
    }
}
