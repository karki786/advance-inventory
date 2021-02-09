<?php namespace CodedCell\Repository\Invoice;

use App\Company;
use App\Invoice;
use App\InvoiceItem;
use App\ProductLocation;
use App\SalesOrder;
use App\StorageLocation;
use Auth;
use Carbon\Carbon;
use CodedCell\Repository\Product\ProductInterface;
use DB;



class InvoiceEntity implements InvoiceInterface
{
    protected $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function all($columns = array('*'), $scope = null)
    {
        $invoice = new Invoice();
        if (count($scope) != 0) {
            $invoice = call_user_func(array($invoice, $scope));
        }
        return $invoice->with('items')->orderBy('id', 'desc')->get($columns);
    }

    public function allCombined($id)
    {
        return InvoiceItem::select('discount', 'invoiceid', 'productId', 'productDescription', DB::raw('sum(quantity) as qty'), DB::raw('sum(returned) as returned'), 'convertedPrice', 'tax', 'total')
            ->where('invoiceId', $id)
            ->groupBy('discount', 'invoiceid', 'productId', 'productDescription', 'convertedPrice', 'tax', 'total')
            ->get();
    }


    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $invoice = Invoice::with('items');
        if ($filter != null) {
            $invoice = $invoice->where('invoiceNo', 'LIKE', '%' . $filter . '%')
                ->orwhere('customerText', 'LIKE', '%' . $filter . '%')
                ->orwhere('salesPersonText', 'LIKE', '%' . $filter . '%')
                ->orwhere('invoiceDate', 'LIKE', '%' . $filter . '%')
                ->orwhere('dueDate', 'LIKE', '%' . $filter . '%')
                ->orwhere('currencyTypeText', 'LIKE', '%' . $filter . '%')
                ->orwhere('paymentMethod', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $invoice = $invoice->$scope();
        }
        if ($paginate) {
            return $invoice->paginate($perPage, $columns);
        } else {
            return $invoice->get();
        }
    }

    private function buildinvoiceNumber($lpoString, $model)
    {
        $vars = array(
            '{$invoiceNumber}' => $model->id,
            '{$date}' => Carbon::now()->day,
            '{$month}' => Carbon::now()->month,
            '{$year}' => Carbon::now()->year,
        );

        return strtr($lpoString, $vars);
    }

    public function create(array $data, $items)
    {

        $invoice = Invoice::create($data);
        $this->createRelation($items, $invoice);
        $invoiceFormat = Company::findOrFail(Auth::user()->companyId)->invoiceNumberingFormat;
        $lpoString = $this->buildinvoiceNumber($invoiceFormat, $invoice);
        $invoice->update(['invoiceNo' => $lpoString]);
        /**  Move to Observer
         * $order = SalesOrder::find($data['salesOrderId']);
         * if ($order) {
         * $order->update(array('invoiced' => 1));
         * }
         * */
        return $invoice;
    }


    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            $array->productId = $array->prod_id;
            $array = array_except((array)$array, ['prod_id', 'price', 'has_error', 'error']);
            array_push($empty, new InvoiceItem((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->items()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        $invoice = Invoice::findOrFail($id);
        if (Auth::user()->can('update', $invoice)) {
            $invoice->update($data);
        }

    }

    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
        if (Auth::user()->can('delete', $invoice)) {
            return Invoice::destroy($id);
        }

    }


    public function find($id, $columns = array('*'))
    {
        return Invoice::with('items')->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Invoice::where($field, '=', $value)->firstOrFail($columns);
    }

}