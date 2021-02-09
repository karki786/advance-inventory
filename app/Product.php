<?php namespace App;

use Auth;
use Carbon\Carbon;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;

    protected $presenter = 'CodedCell\Presenters\Product';


    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->categoryId) {
                $category = ProductCategory::find($model->categoryId);
                $model->categoryName = $category->categoryName;
            }
            $user = Auth::user();
            $model->companyId = $user->companyId;
            $model->createdBy = $user->id;
        });

        static::updating(function ($model) {
            if ($model->categoryId) {
                $category = ProductCategory::find($model->categoryId);
                $model->categoryName = $category->categoryName;
            }
            if (Auth::check()) {
                $user = Auth::user();
                $model->companyId = $user->companyId;
                $model->updatedBy = $user->id;
            }

        });
    }


    protected $revisionFormattedFieldNames = array(
        'amount' => 'Product Ammount',
        'small_name' => 'Nickname',
        'deleted_at' => 'Deleted At'
    );
    protected $dates = ['deleted_at'];
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excsoluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the Photos of a product
     */
    public function photos()
    {
        return $this->hasMany('App\ProductPhotos', 'productId', 'id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function restocks()
    {
        return $this->hasMany('App\Restock', 'productID', 'id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function category()
    {
        return $this->hasOne('App\ProductCategory', 'id', 'categoryId');
    }

    /**
     * Get the comments for the blog post.
     */
    public function dispatches()
    {
        return $this->hasMany('App\Dispatch', 'dispatchedItem', 'id');
    }

    public function invoiceitems()
    {
        return $this->hasMany('App\InvoiceItem', 'productId', 'id');
    }

    public function purchaseorderitems()
    {
        return $this->hasMany('App\PurchaseOrderItem', 'productId', 'id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function locations()
    {
        return $this->hasMany('App\ProductLocation', 'productId', 'id');
    }

    public function scopeLow($query)
    {
        return $query->whereRaw('amount < reorderAmount');
    }

    public function scopeTrash($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeLastUpdate($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeCategory($query, $id)
    {
        return $query->where('categoryId', $id);
    }

    public function scopeWarehouse($query, $id)
    {
        return $query->whereHas('locations', function ($query) use ($id) {
            $query->whereProductlocation($id);
        });
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

    public function scopeRestocks($query)
    {
        return $query->orderBy('restocks_count', 'desc');
    }

}
