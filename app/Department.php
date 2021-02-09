<?php namespace App;

use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use ActionTrait;
    use PresentableTrait;
    use MultitenantTrait;
    protected $presenter = 'CodedCell\Presenters\Department';
    use softDeletes;

    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getDates()
    {
        return [];
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function dispatches()
    {
        return $this->hasMany('App\Dispatch', 'departmentId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    public function setBudgetLimitAttribute($value)
    {
        $this->attributes['budgetLimit'] = trim($value) !== '' ? $value : null;
    }

    public function setDepartmentEmailAttribute($value)
    {
        $this->attributes['departmentEmail'] = trim($value) !== '' ? $value : null;
    }

    public function setBudgetStartDateAttribute($value)
    {
        $this->attributes['budgetStartDate'] = trim($value) !== '' ? $value : null;
    }

    public function setBudgetEndDateAttribute($value)
    {
        $this->attributes['budgetEndDate'] = trim($value) !== '' ? $value : null;
    }

}
