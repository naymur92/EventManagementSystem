<?php

namespace App\Http\Controllers\Reports;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Session;
use App\Utils\CSVExporter;
use Exception;

class EventReportController extends Controller
{
    public bool $isEventListReport = true;

    /**
     * Report index page
     *
     * @return void
     */
    public function index(): void
    {
        $searchParams = array();
        $reportResult = $this->getReportData($searchParams);

        view('admin.pages.reports.event-report', array('title' => "Event Report", 'reportResult' => $reportResult, 'searchParams' => $searchParams));
    }


    /**
     * Generate report
     *
     * @param Request $request
     * @return void
     */
    public function generate(Request $request): void
    {
        $request->setSanitizationRules([
            'name' => ['string'],
            'host_name' => ['string'],
            'from_date' => ['string'],
            'to_date' => ['string'],
            'reg_fee_from' => ['integer'],
            'reg_fee_to' => ['integer'],
            'seat_cap_from' => ['integer'],
            'seat_cap_to' => ['integer'],
            'av_seat_from' => ['integer'],
            'av_seat_to' => ['integer'],
            'status' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'string',
            'host_name' => 'string',
            'from_date' => 'string',
            'to_date' => 'string',
            'reg_fee_from' => 'integer|min:0',
            'reg_fee_to' => 'integer|min:0',
            'seat_cap_from' => 'integer|min:0',
            'seat_cap_to' => 'integer|min:0',
            'av_seat_from' => 'integer|min:0',
            'av_seat_to' => 'integer|min:0',
            'status' => 'integer|min:0',
        ];

        $request->validate($rules);

        $errors = $request->errors();

        try {
            if (!empty($errors)) {
                throw new Exception("Validation error!");
            }

            $requestData = $request->validated();

            $reportResult = $this->getReportData($requestData);

            // dd($reportResult);

            view('admin.pages.reports.event-report', array('title' => "Event Report", 'reportResult' => $reportResult, 'searchParams' => $requestData));
        } catch (Exception $e) {
            Session::flash('flash_error', $e->getMessage());
            redirect('/admin/reports/event-report');
        }
    }


    /**
     * Get selected columns
     *
     * @return string
     */
    private function getSelectColumnsForEventReport(): string
    {
        return "SELECT
                    ev.name event_name,
                    h.name host_name,
                    ev.location,
                    ev.start_time,
                    ev.end_time,
                    ev.registration_fee,
                    ev.max_capacity total_seat,
                    ev.current_capacity available_seat,
                    COUNT(a.attendee_id) total_registration,
                    SUM(a.payment_amount) total_payment_collection,
                    CASE 
                        WHEN ev.status = 0 THEN 'Pending'
                        WHEN ev.status = 1 THEN 'Published'
                        WHEN ev.status = 2 THEN 'Blocked'
                        ELSE 'Unknown' 
                    END AS status
                ";
    }

    /**
     * Get selected columns for Attendee List report
     *
     * @return string
     */
    private function getSelectColumnsForAttendeeListReport(): string
    {
        return "SELECT
                    h.name host_name,
                    ev.name event_name,
                    ev.start_time,
                    ev.end_time,
                    CASE 
                        WHEN ev.status = 0 THEN 'Pending'
                        WHEN ev.status = 1 THEN 'Published'
                        WHEN ev.status = 2 THEN 'Blocked'
                        ELSE 'Unknown' 
                    END AS event_status,
                    a.booking_no,
                    a.name attendee_name,
                    a.email attendee_email,
                    a.mobile attendee_mobile,
                    ev.registration_fee,
                    a.payment_amount,
                    a.payment_trnx_no,
                    a.payment_account_no,
                    a.registration_time,
                    IF(a.status = 0, 'Cancelled', 'Confirmed') status
                ";
    }


    /**
     * Ready sql and params and return sql
     *
     * @param array $requestData
     * @param array $params
     * @return string
     */
    private function readySql(array &$requestData, array &$params): string
    {
        if ($this->isEventListReport) {
            $sql = $this->getSelectColumnsForEventReport();
        } else {
            $sql = $this->getSelectColumnsForAttendeeListReport();
        }

        $sql .= " FROM events ev
                JOIN users h ON ev.user_id=h.user_id
                JOIN attendees a ON a.event_id=ev.event_id                        
                ";

        $whereConditions = array();

        // host user
        if (Auth::user()->type == 2) {
            $whereConditions[] = 'ev.user_id = ?';
            $params[] = Auth::user()->user_id;
        }

        // event name
        if (isset($requestData['name']) && !empty($requestData['name'])) {
            $whereConditions[] = 'ev.name LIKE ?';
            $params[] = "%{$requestData['name']}%";
        }

        // host name
        if (isset($requestData['host_name']) && !empty($requestData['host_name'])) {
            $whereConditions[] = 'h.name LIKE ?';
            $params[] = "%{$requestData['host_name']}%";
        }

        // start or end date is greater than from_date
        if (isset($requestData['from_date']) && !empty($requestData['from_date'])) {
            $start = date('Y-m-d 00:00:00', strtotime($requestData['from_date']));
            $whereConditions[] = '(ev.start_time >= ? OR ev.end_time >= ?)';
            $params[] = $start;
            $params[] = $start;
        }

        // start or end date is less than to_date
        if (isset($requestData['to_date']) && !empty($requestData['to_date'])) {
            $end = date('Y-m-d 23:59:59', strtotime($requestData['to_date']));
            $whereConditions[] = '(ev.start_time <= ? OR ev.end_time <= ?)';
            $params[] = $end;
            $params[] = $end;
        }

        // registration fee
        if (isset($requestData['reg_fee_from']) && !empty($requestData['reg_fee_from'])) {
            $whereConditions[] = 'ev.registration_fee >= ?';
            $params[] = $requestData['reg_fee_from'];
        }
        if (isset($requestData['reg_fee_to']) && !empty($requestData['reg_fee_to'])) {
            $whereConditions[] = 'ev.registration_fee <= ?';
            $params[] = $requestData['reg_fee_to'];
        }

        // seat capacity
        if (isset($requestData['seat_cap_from']) && !empty($requestData['seat_cap_from'])) {
            $whereConditions[] = '(ev.max_capacity >= ? OR ev.max_capacity = 0)';
            $params[] = $requestData['seat_cap_from'];
        }
        if (isset($requestData['seat_cap_to']) && !empty($requestData['seat_cap_to'])) {
            $whereConditions[] = '(ev.max_capacity <= ? AND ev.max_capacity != 0)';
            $params[] = $requestData['seat_cap_to'];
        }

        // available seats
        if (isset($requestData['av_seat_from']) && !empty($requestData['av_seat_from'])) {
            $whereConditions[] = '(ev.current_capacity >= ? OR ev.max_capacity = 0)';
            $params[] = $requestData['av_seat_from'];
        }
        if (isset($requestData['av_seat_to']) && !empty($requestData['av_seat_to'])) {
            $whereConditions[] = '(ev.current_capacity <= ? AND ev.max_capacity != 0)';
            $params[] = $requestData['av_seat_to'];
        }

        // status
        if (isset($requestData['status']) && ($requestData['status'] >= 0)) {
            $whereConditions[] = 'ev.status = ?';
            $params[] = $requestData['status'];
        }

        $whereConditionStr = implode(" AND ", $whereConditions);

        if ($whereConditionStr != '')
            $sql .= " WHERE " . $whereConditionStr;

        // group by and sorting
        if ($this->isEventListReport) {
            $sql .= " GROUP BY ev.event_id ORDER BY ev.start_time, ev.name, h.name";
        } else {
            $sql .= " ORDER BY h.name, ev.name, a.booking_no";
        }

        if (count($params) == 0 || (count($params) == 1 && Auth::user()->type == 2)) {
            $sql .= " LIMIT 500";
        }

        return $sql;
    }


    /**
     * Get report data
     *
     * @return array|null
     */
    private function getReportData(&$requestData): ?array
    {
        $params = array();
        $sql = $this->readySql($requestData, $params);

        return DB::query($sql, $params)->fetchAll();
    }


    /**
     * Download event report
     *
     * @param Request $request
     * @return void
     */
    public function downloadEventReport(Request $request): void
    {
        $request->setSanitizationRules([
            'name' => ['string'],
            'host_name' => ['string'],
            'from_date' => ['string'],
            'to_date' => ['string'],
            'reg_fee_from' => ['integer'],
            'reg_fee_to' => ['integer'],
            'seat_cap_from' => ['integer'],
            'seat_cap_to' => ['integer'],
            'av_seat_from' => ['integer'],
            'av_seat_to' => ['integer'],
            'status' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'string',
            'host_name' => 'string',
            'from_date' => 'string',
            'to_date' => 'string',
            'reg_fee_from' => 'integer|min:0',
            'reg_fee_to' => 'integer|min:0',
            'seat_cap_from' => 'integer|min:0',
            'seat_cap_to' => 'integer|min:0',
            'av_seat_from' => 'integer|min:0',
            'av_seat_to' => 'integer|min:0',
            'status' => 'integer|min:0',
        ];

        $request->validate($rules);

        $errors = $request->errors();

        try {
            if (!empty($errors)) {
                throw new Exception("Validation error!");
            }

            $requestData = $request->validated();

            $reportResult = $this->getReportData($requestData);

            $headers = [
                "Event Name",
                "Host Name",
                "Location",
                "Start Time",
                "End Time",
                "Registration Fee",
                "Total Seat",
                "Available Seat",
                "Total Registration",
                "Total Payment Received",
                "Event Status"
            ];

            $fileName = 'event_report_event_list.csv';

            $csvExporter = new CSVExporter($reportResult, $fileName);
            $csvExporter->setHeaders($headers);

            $csvExporter->download();
        } catch (Exception $e) {
            Session::flash('flash_error', $e->getMessage());
            redirect('/admin/reports/event-report');
        }
    }


    /**
     * Download attendee list report
     *
     * @param Request $request
     * @return void
     */
    public function downloadAttendeeListReport(Request $request): void
    {
        $request->setSanitizationRules([
            'name' => ['string'],
            'host_name' => ['string'],
            'from_date' => ['string'],
            'to_date' => ['string'],
            'reg_fee_from' => ['integer'],
            'reg_fee_to' => ['integer'],
            'seat_cap_from' => ['integer'],
            'seat_cap_to' => ['integer'],
            'av_seat_from' => ['integer'],
            'av_seat_to' => ['integer'],
            'status' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'string',
            'host_name' => 'string',
            'from_date' => 'string',
            'to_date' => 'string',
            'reg_fee_from' => 'integer|min:0',
            'reg_fee_to' => 'integer|min:0',
            'seat_cap_from' => 'integer|min:0',
            'seat_cap_to' => 'integer|min:0',
            'av_seat_from' => 'integer|min:0',
            'av_seat_to' => 'integer|min:0',
            'status' => 'integer|min:0',
        ];

        $request->validate($rules);

        $errors = $request->errors();

        try {
            if (!empty($errors)) {
                throw new Exception("Validation error!");
            }

            $requestData = $request->validated();

            $this->isEventListReport = false;

            $reportResult = $this->getReportData($requestData);

            $headers = ["Host Name", "Event Name", "Start Time", "End Time", "Event Status", "Booking Number", "Attendee Name", "Attendee Email", "Attendee Mobile", "Registration Fee", "Payment Amount", "Payment Trnx No", "Payment Account No", "Registration Time", "Status"];

            $fileName = 'event_report_attendee_list.csv';

            $csvExporter = new CSVExporter($reportResult, $fileName);
            $csvExporter->setHeaders($headers);

            $csvExporter->download();
        } catch (Exception $e) {
            Session::flash('flash_error', $e->getMessage());
            redirect('/admin/reports/event-report');
        }
    }
}
