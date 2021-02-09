<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/5/2016
 * Time: 05:55
 */

namespace CodedCell\Repository\Currency;


use App\Currency;
use Auth;

class CurrencyEntity implements CurrencyInterface
{
    public function all($columns = array('*'))
    {
        return Currency::get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return Currency::paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        return Currency::create($data);
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];

        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        return null;
    }

    public function update(array $data, $id)
    {
        $currency = Currency::findOrFail($id);
        if (Auth::user()->can('update', $currency)) {
            return $currency->update($data);
        }

    }

    public function delete($id)
    {
        $currency = Currency::findOrFail($id);
        if (Auth::user()->can('delete', $currency)) {
            return Currency::destroy($id);
        }


    }

    public function find($id, $columns = array('*'))
    {
        return Currency::findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Currency::where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     * Get Current Currency
     * @return mixed
     *
     */
    public function getCurrentCurrency($date, $currency)
    {
        return Currency::where('startDate', '<', $date)->where('endDate', '>', $date)->where('currency', '=', $currency)->first();
    }

}