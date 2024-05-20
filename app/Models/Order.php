<?php

namespace App\Models;

use App\Models\Scopes\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, Notifiable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'qnty',
        'total',
    ];


    /**
     * The attributes that are searchables.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'sku',
        'price',
    ];


    /**
     * The attributes that are filterables.
     *
     * @var array<int, string>
     */
    protected $filterable = [
        'name',
        'sku',
        'price',
    ];


    /**
    * Get the users from orders
    * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
    * Get the products from orders
    * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


}
