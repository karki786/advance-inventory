<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 27/Jun/2017
 * Time: 12:23 PM
 */

namespace CodedCell\Repository\Translation;


use App\Translation;

class TranslationEntity implements TranslationInterface
{
    public function all($columns = array('*'))
    {
        return Translation::with('lang')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $translation = Translation::with([
                'lang'
            ]
        );
        if ($filter != null) {
            $translation = $translation->where('orig_lang', 'LIKE', '%' . $filter . '%')
                ->orwhere('module', 'LIKE', '%' . $filter . '%')
                ->orwhere('language', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {
                $parameter = $scope[1];
                $scope = $scope[0];
                $translation = $translation->$scope($parameter);
            } else {
                $translation = $translation->$scope();
            }
        }

        if ($paginate) {
            return $translation->orderBy('module', 'language')->paginate($perPage, $columns);
        } else {
            return $translation->orderBy('module', 'language')->get();
        }
    }

    public function create(array $data)
    {
        return Translation::create($data);
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new lang((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->lang()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        return Translation::find($id)->update($data);
    }

    public function delete($id)
    {
        return Translation::destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return Translation::with('lang')->find($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Translation::where($field, '=', $value)->first($columns);
    }

}