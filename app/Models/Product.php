<?php

namespace App\Models;

use App\Models\Scopes\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'description',
        'price',
        'stock',
        'available',
        'section_id',
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
        'section_id',
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
        'section_id',
    ];

    /**
     * Get the section from product
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
    * format price
    *
    */
    public function price_format($price): String
    {
        return number_format($price, 2, ',', '.');
    }
}
