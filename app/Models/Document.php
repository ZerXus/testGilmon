<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'createAt';
    const UPDATED_AT = 'modifyAt';
    protected $dateFormat = 'Y-m-d H:m:sP';

    protected $fillable = [
        'id',
        'status',
        'payload'
    ];

    protected $attributes = [
        'status' => 'draft',
        'payload' => '{}'
    ];
}
