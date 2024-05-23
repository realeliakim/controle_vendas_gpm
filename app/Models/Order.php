<?php

namespace App\Models;

use App\Models\Scopes\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'saler_id',
        'customer_id',
    ];


    /**
    * Get the saler from orders
    * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function saler(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
    * Get the customer from orders
    * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products from orders
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->as('products')
            ->withPivot(
                'price_saled',
                'qnty_saled',
            )
            ->withTimestamps();
    }

}
