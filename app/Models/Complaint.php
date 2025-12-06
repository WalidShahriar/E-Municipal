<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    // Define the fields that can be mass assigned
    protected $fillable = [
        'complaint_id',
        'title',
        'category',
        'description',
        'location',
        'attachment_name',
        'department',
        'status',
    ];
}
