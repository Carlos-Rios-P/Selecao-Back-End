<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    const ADMIN = 'admin';
    const CUSTOMER = 'customer';

    const ID_ADMIN = 1;
    const ID_CUSTOMER = 2;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
