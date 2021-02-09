<?php namespace CodedCell\Presenters;

/**
 * Class Product
 * @package CodedCell\Presenters
 */
class Language extends Presenter
{
    protected $entity;


    public function translate()
    {
        return '<a class="btn btn-sm btn-flat btn-block bg-red" href="'.action('TranslationController@index',array('id'=>$this->entity->id)).'"><small><i class="fa fa-globe"></i> Translate</small></a>';

    }


}
