<?php namespace CodedCell\Traits;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Request;

class MultitenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $table = $model->getTable() . '.companyId';
        if (Auth::check()) {
            $builder->with('creator')->with('updater');
            $builder->where($table, '=', Auth::user()->companyId);
        } elseif (Auth::guard('customer')->check()) {
            $builder->where($table, '=', Auth::guard('customer')->user()->companyId);
        } else {
            $model = $builder->getModel();
            // apply a constraint that will never be true
            // so that no records are fetched for unauthorized users
            $builder->whereNull($model->getKeyName());
        }
    }

    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();
        $val = null;
        foreach ($query->wheres as $key => $where) {
            if ($where['column'] == 'id' and $where['type'] == 'Null') {
                $val = $key;
            }
        }
        $arr = $query->wheres;
        unset($arr[$val]);
        $query->wheres = $arr;
    }

}