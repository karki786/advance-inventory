<?php namespace CodedCell\Repository\Customer;

use App\Customer;
use App\CustomerContact;
use Hash;
use Auth;

class CustomerEntity implements CustomerInterface
{
    public function all($columns = array('*'), $scope = null)
    {
        $customer = new Customer();
        if (count($scope) != 0) {
            $customer = call_user_func(array($customer, $scope));
        }
        return $customer->with('contacts')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $customer = Customer::with('contacts');
        if ($filter != null) {
            $customer = $customer->where('companyName', 'LIKE', '%' . $filter . '%')
                ->orwhere('companyEmail', 'LIKE', '%' . $filter . '%')
                ->orwhere('email', 'LIKE', '%' . $filter . '%')
                ->orwhere('city', 'LIKE', '%' . $filter . '%')
                ->orwhere('country', 'LIKE', '%' . $filter . '%')
                ->orwhere('surname', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $customer = $customer->$scope();
        }
        if ($paginate) {
            return $customer->paginate($perPage, $columns);
        } else {
            return $customer->get();
        }
    }

    public function create(array $data, $contacts)
    {
        $contacts = (array)json_decode($contacts);
        if ($data['password'] != null or $data['password'] != '') {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $customer = Customer::create($data);
        $this->createRelation($contacts, $customer);
        return $customer;
    }

    private function buildRelationShip($arrayItems)
    {

        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new CustomerContact((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->contacts()->saveMany($data);
    }

    public function update(array $data, array $items, $id)
    {
        $customer = Customer::find($id);
        if (Auth::user()->can('update', $customer)) {
            if ($data['password'] != null or $data['password'] != '') {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $customer->update($data);
            foreach ((array)$items as $item) {
                if (isset($item->id)) {
                    $item = collect($item)->except('creator', 'updater', 'created_at', 'updated_at')->toArray();
                    CustomerContact::find($item['id'])->update((array)$item);
                } else {
                    $customer->contacts()->create((array)$item);
                }
            }
            return $customer;
        }
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        if (Auth::user()->can('delete', $customer)) {
            return Customer::destroy($id);
        }

    }

    public function find($id, $columns = array('*'))
    {
        return Customer::with('contacts')
            ->with('invoices')
            ->with('invoiceItems')
            ->with('payments')
            ->with('quotes')
            ->with('returns')
            ->find($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Customer::where($field, '=', $value)->firstOrFail($columns);
    }

    public function getContacts($companyId)
    {
        return CustomerContact::select('id', 'customerName as text')->where('customerId', '=', $companyId)->get();
    }

    public function checkCustomerCredit($id)
    {

    }

    public function getPendingPayments($id)
    {
        $customer = Customer::with('invoices')->find($id);
        $invoiceAmount = 0;
        foreach ($customer->invoices as $invoice) {
            $invoiceAmount = $invoiceAmount + $invoice->items->sum('total') + $invoice->items->sum('tax');
        }
        $paymentAmount = 0;
        foreach ($customer->invoices as $invoice) {
            $paymentAmount = $paymentAmount + $invoice->payment->sum('paymentAmount');
        }
        return $invoiceAmount - $paymentAmount;
    }


}