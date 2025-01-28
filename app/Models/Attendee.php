<?php

namespace App\Models;

class Attendee extends BaseModel
{
    protected $table = 'attendees';
    protected $primaryKey = 'attendee_id';
    protected array $fillable = ['event_id', 'user_id', 'email', 'mobile', 'payment_trnx_no', 'payment_amount', 'payment_account_no', 'registration_time', 'status'];
}
