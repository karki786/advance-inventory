<?php namespace CodedCell\Repository\Category;

use App\Product;
use App\ProductCategory;
use Illuminate\Auth\Access\Gate;
use Auth;

class CategoryEntity implements CategoryInterface
{
    public function all($columns = array('*'))
    {
        return ProductCategory::with('products')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $productCategories = ProductCategory::with('products');
        if ($filter != null) {
            $productCategories = $productCategories->where('categoryName', 'LIKE', '%' . $filter . '%')
                ->orwhere('categoryDescription', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            $productCategories = $productCategories->$scope();
        }
        if ($paginate) {
            return $productCategories->paginate($perPage, $columns);
        } else {
            return $productCategories->get();
        }
    }

    public function paginateDetails($id, $perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $product = Product::with([
                'category'
            ]
        )->where('categoryId', $id);
        if ($filter != null) {
            $product = $product->where('productName', 'LIKE', '%' . $filter . '%')
                ->orwhere('categoryName', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {

            } else {
                $product = $product->$scope();
            }

        }

        if ($paginate) {
            return $product->paginate($perPage, $columns);
        } else {
            return $product->get();
        }
    }

    public function create(array $data)
    {
        return ProductCategory::create($data);
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new Product((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->products()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        $category = ProductCategory::findOrFail($id);
        if (Auth::user()->can('update', $category)) {
            $category->update($data);
        }


    }

    public function delete($id)
    {
        $category = ProductCategory::findOrFail($id);
        if (Auth::user()->can('delete', $category)) {
            $category->destroy($id);
        }

    }

    public function find($id, $columns = array('*'))
    {
        return ProductCategory::with('products')->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return ProductCategory::where($field, '=', $value)->firstOrFail($columns);
    }

}