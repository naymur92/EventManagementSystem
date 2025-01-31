<?php

namespace App\Models;

use App\Core\DB;

class Attendee extends BaseModel
{
    protected $table = 'attendees';
    protected $primaryKey = 'attendee_id';
    protected array $fillable = ['event_id', 'booking_no', 'user_id', 'name', 'email', 'mobile', 'payment_trnx_no', 'payment_amount', 'payment_account_no', 'registration_time', 'status', 'cancel_message'];


    /**
     * Generate unique booking number
     *
     * @param integer $event_id
     * @return string
     */
    public function generateBookingNumber(int $event_id): string
    {
        $prefix = "EV";
        $maxLength = 10;

        $lastBookingNumber = $this->where('event_id', '=', $event_id)->select(['booking_no'])->orderBy('registration_time', "DESC")->get()[0] ?? "";

        if ($lastBookingNumber) {
            $lastNumber = (int) substr($lastBookingNumber['booking_no'], strlen($prefix . $event_id));
            $baseNumber = $lastNumber + 1;
        } else {
            $baseNumber = 1;
        }

        do {
            $bookingNumber = sprintf("%s%s%0" . ($maxLength - strlen($prefix . $event_id)) . "d", $prefix, $event_id, $baseNumber);

            // Check if the booking number exists in the database
            $exists = $this->where('booking_no', '=', $bookingNumber)->get();

            $baseNumber++;
        } while ($exists);

        return $bookingNumber;
    }
}
