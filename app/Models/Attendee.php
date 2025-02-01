<?php

namespace App\Models;

use App\Core\DB;

class Attendee extends BaseModel
{
    protected $table = 'attendees';
    protected $primaryKey = 'attendee_id';
    protected array $fillable = ['event_id', 'booking_no', 'user_id', 'name', 'email', 'mobile', 'payment_trnx_no', 'payment_amount', 'payment_account_no', 'registration_time', 'status', 'cancel_reason'];


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


    /**
     * Get ticket data
     *
     * @param string $unique_id
     * @return array|null
     */
    public static function generateTicketData(string $unique_id): ?array
    {
        [$bookingNo, $attendeeId] = decodeData($unique_id);

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    ev.registration_fee,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    u.name host_name,
                    u.email host_email,
                    u.mobile host_mobile,
                    a.attendee_id,
                    a.booking_no,
                    a.name attendee_name,
                    a.email attendee_email,
                    a.mobile attendee_mobile,
                    a.payment_trnx_no,
                    a.payment_amount,
                    a.payment_account_no,
                    a.registration_time
                FROM attendees a
                JOIN events ev
                    ON a.event_id = ev.event_id
                JOIN users u
                    ON u.user_id = ev.user_id
                WHERE a.status = ? AND a.booking_no = ? AND a.attendee_id = ?";

        $params[] = 1;
        $params[] = $bookingNo;
        $params[] = $attendeeId;

        return DB::query($sql, $params)->fetchAll();
    }
}
