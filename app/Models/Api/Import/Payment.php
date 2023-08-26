<?php

namespace App\Models\Api\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "payment";
    const CREATED_AT = "created";
    const DELETED_AT = "deleted";
    const UPDATED_AT = null;

    protected $casts = [
        'created' => 'datetime:Y-m-d H:i:s',
        'deleted' => 'datetime:Y-m-d',
    ];
}
