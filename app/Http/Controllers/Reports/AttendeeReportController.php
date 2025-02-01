<?php

namespace App\Http\Controllers\Reports;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Session;
use App\Utils\CSVExporter;
use Exception;

class AttendeeReportController extends Controller
{
    /**
     * Report index page
     *
     * @return void
     */
    public function index(): void
    {
        $searchParams = array();
        $reportResult = $this->getReportData($searchParams);

        view('admin.pages.reports.attendee-report', array('title' => "Attendee Report", 'reportResult' => $reportResult, 'searchParams' => $searchParams));
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
            'from_date' => ['string'],
            'to_date' => ['string'],
            'reg_fee_from' => ['integer'],
            'reg_fee_to' => ['integer'],
            'attendee_name' => ['string'],
            'attendee_email' => ['email'],
            'attendee_mobile' => ['string'],
            'status' => ['integer'],
            't_status' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'string',
            'from_date' => 'string',
            'to_date' => 'string',
            'reg_fee_from' => 'integer|min:0',
            'reg_fee_to' => 'integer|min:0',
            'attendee_name' => 'string',
            'attendee_email' => 'email',
            'attendee_mobile' => 'string',
            'status' => 'integer|min:0',
            't_status' => 'integer|min:0',
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

            view('admin.pages.reports.attendee-report', array('title' => "Event Report", 'reportResult' => $reportResult, 'searchParams' => $requestData));
        } catch (Exception $e) {
            Session::flash('flash_error', $e->getMessage());
            redirect('/admin/reports/attendee-report');
        }
    }

    /**
     * Get selected columns for Attendee List report
     *
     * @return string
     */
    private function getSelectColumns(): string
    {
        return "SELECT
                    h.name host_name,
                    ev.name event_name,
                    ev.start_time,
                    ev.end_time,
                    a.booking_no,
                    a.name attendee_name,
                    a.email attendee_email,
                    a.mobile attendee_mobile,
                    ev.registration_fee,
                    a.payment_amount,
                    a.payment_trnx_no,
                    a.payment_account_no,
                    a.registration_time,
                    IF(a.status = 0, 'Cancelled', 'Confirmed') status,
                    a.cancel_reason
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
        $sql = $this->getSelectColumns();

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

        // attendee name
        if (isset($requestData['attendee_name']) && !empty($requestData['attendee_name'])) {
            $whereConditions[] = 'a.name LIKE ?';
            $params[] = "%{$requestData['attendee_name']}%";
        }

        // attendee email
        if (isset($requestData['attendee_email']) && !empty($requestData['attendee_email'])) {
            $whereConditions[] = 'a.email LIKE ?';
            $params[] = "%{$requestData['attendee_email']}%";
        }

        // attendee mobile
        if (isset($requestData['attendee_mobile']) && !empty($requestData['attendee_mobile'])) {
            $whereConditions[] = 'a.mobile LIKE ?';
            $params[] = "%{$requestData['attendee_mobile']}%";
        }

        // status
        if (isset($requestData['status']) && ($requestData['status'] == 0 || $requestData['status'] == 1)) {
            $whereConditions[] = 'ev.status = ?';
            $params[] = $requestData['status'];
        }

        // ticket status
        if (isset($requestData['t_status']) && ($requestData['t_status'] == 0 || $requestData['t_status'] == 1)) {
            $whereConditions[] = 'a.status = ?';
            $params[] = $requestData['t_status'];
        }

        $whereConditionStr = implode(" AND ", $whereConditions);

        if ($whereConditionStr != '')
            $sql .= " WHERE " . $whereConditionStr;

        // group by and sorting
        $sql .= " ORDER BY ev.name, a.booking_no, a.name";

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
     * Download attendee list report
     *
     * @param Request $request
     * @return void
     */
    public function downloadReportData(Request $request): void
    {
        $request->setSanitizationRules([
            'name' => ['string'],
            'from_date' => ['string'],
            'to_date' => ['string'],
            'reg_fee_from' => ['integer'],
            'reg_fee_to' => ['integer'],
            'attendee_name' => ['string'],
            'attendee_email' => ['email'],
            'attendee_mobile' => ['string'],
            'status' => ['integer'],
            't_status' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'string',
            'from_date' => 'string',
            'to_date' => 'string',
            'reg_fee_from' => 'integer|min:0',
            'reg_fee_to' => 'integer|min:0',
            'attendee_name' => 'string',
            'attendee_email' => 'email',
            'attendee_mobile' => 'string',
            'status' => 'integer|min:0',
            't_status' => 'integer|min:0',
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

            $headers = ["Host Name", "Event Name", "Start Time", "End Time", "Booking Number", "Attendee Name", "Attendee Email", "Attendee Mobile", "Registration Fee", "Payment Amount", "Payment Trnx No", "Payment Account No", "Registration Time", "Status", "Cancel Reason"];

            $fileName = 'event_report_attendee_list.csv';

            $csvExporter = new CSVExporter($reportResult, $fileName);
            $csvExporter->setHeaders($headers);

            $csvExporter->download();
        } catch (Exception $e) {
            Session::flash('flash_error', $e->getMessage());
            redirect('/admin/reports/attendee-report');
        }
    }
}
