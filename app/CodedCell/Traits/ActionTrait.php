<?php


namespace CodedCell\Traits;

use Auth;
use Carbon\Carbon;

trait ActionTrait
{
    public function scopeTrash($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeLastUpdate($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeToday($query)
    {
        return $query->where('created_at', '>', Carbon::today())->where('created_at', '<', Carbon::today()->addDay());
    }

    public function scopeWeek($query)
    {
        return $query->where('created_at', '>', Carbon::today()->subWeek())->where('created_at', '<', Carbon::today()->addDay());
    }

    public function scopeMonth($query)
    {
        return $query->where('created_at', '>', Carbon::today()->subMonth())->where('created_at', '<', Carbon::today()->addDay());
    }


    public static function bootActionTrait()
    {
        static::creating(function ($entry) {
            if (Auth::check()) {
                $user = Auth::user();
                $entry->companyId = $user->companyId;
                $entry->createdBy = $user->id;
            }
        });

        static::updating(function ($entry) {
            if (Auth::check()) {
                $user = Auth::user();
                $entry->companyId = $user->companyId;
                $entry->updatedBy = $user->id;
            }

        });


        /**
         * static::updating(function ($model) {
         * //     dd($model->revisionFormattedFieldNames);
         * foreach ($model->getDirty() as $attribute => $value) {
         * dd($model->revisionFormattedFieldNames[$attribute]);
         * $original = $model->getOriginal($attribute);
         * echo "Changed $attribute from '$original' to '$value'<br/>\r\n";
         * }
         * dd("here");
         * });
         **/


    }
}