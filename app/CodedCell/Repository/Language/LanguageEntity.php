<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 27/Jun/2017
 * Time: 11:46 AM
 */

namespace CodedCell\Repository\Language;


use App\Language;
use App\Translation;

class LanguageEntity implements LanguageInterface
{
    public function all($columns = array('*'))
    {
        return Language::with('translations')->get($columns);
    }

    public function paginate($perPage = 15, $filter = null, $scope = null, $paginate = true, $columns = array('*'))
    {
        $language = Language::with([
                'translations'
            ]
        );
        if ($filter != null) {
            $language = $language->where('language', 'LIKE', '%' . $filter . '%')
                ->orwhere('language_full', 'LIKE', '%' . $filter . '%');
        }
        if ($scope != null) {
            if (is_array($scope)) {
                $parameter = $scope[1];
                $scope = $scope[0];
                $language = $language->$scope($parameter);
            } else {
                $language = $language->$scope();
            }
        }

        if ($paginate) {
            return $language->paginate($perPage, $columns);
        } else {
            return $language->get();
        }
    }

    public function create(array $data)
    {
        return Language::create($data);
    }

    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new Translation((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->translations()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        return Language::find($id)->update($data);
    }

    public function delete($id)
    {
        return Language::destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return Language::with('translations')->find($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Language::where($field, '=', $value)->first($columns);
    }

}