<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasUuids, HasFactory;
    //
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'document_number',
        'state',
        'city',
        'manager_id',
    ];

    protected function documentNumber(): Attribute
    {
        return Attribute::make(
            set: static fn (string $value) => preg_replace('/\D/', '', $value)
        );
    }

    public function manager(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }
}
