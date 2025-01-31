<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use Exception;

class EventApiController extends Controller
{

    /**
     * Get schedule dates API
     *
     * @param Request $request
     * @return void
     */
    public function getEventSchedules(Request $request): void
    {
        $request->setSanitizationRules([
            'limit' => ['integer']
        ]);

        $data = $request->all();
        $limit = $data['limit'] ?? 500; // default limit is 500

        $params = array();
        $sql = "SELECT 
                    DISTINCT(DATE_FORMAT(start_time, '%Y-%m-%d')) date
                FROM events
                WHERE start_time >= ?
                    AND status = ?
                ORDER BY date ASC";

        $params[] = date('Y-m-d H:i:s');
        $params[] = 1;

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        try {
            $schedules = DB::query($sql, $params)->fetchAll();

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $schedules,
            ), 200);
        } catch (Exception $e) {
            Response::json(array(
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ), 400);
        }
    }


    /**
     * Get events API
     *
     * @param Request $request
     * @return void
     */
    public function getEvents(Request $request): void
    {
        $request->setSanitizationRules([
            'date' => ['string'],
            'host_id' => ['integer'],
            'limit' => ['integer'],
        ]);

        $data = $request->all();

        $date = $data['date'] ?? '';
        $host_id = $data['host_id'] ?? '';
        $limit = $data['limit'] ?? 500; // default limit is 500

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    CONCAT('/uploads/', f.filepath, '/', f.filename) banner_image
                FROM events ev
                LEFT JOIN files f 
                    ON f.table_id=ev.event_id
                    AND f.operation_name = 'events'  
                    AND f.fileinfo = 'banner_image'
                WHERE ev.status = ?
                    AND (ev.current_capacity > 0 OR ev.max_capacity = 0)";
        $params[] = 1;

        if (!empty($date)) {
            $sql .= " AND ev.start_time BETWEEN ? AND ?";
            $params[] = date('Y-m-d 00:00:00', strtotime($date));
            $params[] = date('Y-m-d 23:59:59', strtotime($date));
        }

        if (!empty($host_id)) {
            $sql .= " AND ev.user_id  = ?";
            $params[] = $host_id;
        }

        $sql .= " ORDER BY ev.start_time ASC, f.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        // echo $sql, '<br>';
        // print_r($params);
        // die;

        try {
            $events = DB::query($sql, $params)->fetchAll();

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $events,
            ), 200);
        } catch (Exception $e) {
            Response::json(array(
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ), 400);
        }
    }
}
