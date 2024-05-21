<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Scopes\Filterable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'cpf',
        'user_type_id',
        'section_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that are searchables.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'email',
        'cpf',
        'user_type_id',
        'section_id',
    ];

    /**
     * The attributes that are filterables.
     *
     * @var array<int, string>
     */
    protected $filterable = [
        'name',
        'email',
        'cpf',
        'user_type_id',
        'section_id',
    ];

    /**
     * The attributes that are orderables.
     *
     * @var array<int, string>
     */
    protected $orderable = [
        'name',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user_type from user
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_type(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Get the section from user
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
