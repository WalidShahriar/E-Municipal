<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields can be safely updated via Model::create()
     */
    protected $fillable = [
        'request_id',
        'title',
        'category',
        'description',
        'location',
        'attachment_name',
        'department',
        'status',
        'manager_remarks',
        'submitted_by',
    ];
}