<?php

namespace App\Models;

use App\Enums\Event\Status;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'number',
        'title',
        'description',
        'location',
        'pic',
        'event_category_id',
        'company_id',
        'requestor_id',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }
}
