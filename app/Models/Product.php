<?php

namespace App\Models;

use App\Models\Scopes\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Notifiable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'in-stock',
        'available',
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
    * Get the orders from product
    * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


}
