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
                    AND f.deleted_by IS NULL
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

    /**
     * Get events details API
     *
     * @param Request $request
     * @return void
     */
    public function getEventDetails(Request $request): void
    {
        $request->setSanitizationRules([
            'event_id' => ['integer']
        ]);

        $data = $request->all();

        $event_id = $data['event_id'] ?? '';

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    ev.google_map_location,
                    ev.description,
                    ev.max_capacity,
                    ev.registration_fee,
                    ev.current_capacity,
                    ev.user_id host_id,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    CONCAT('/uploads/', f.filepath, '/', f.filename) banner_image,
                    CONCAT('/uploads/', hf.filepath, '/', hf.filename) host_profile_image,
                    u.name host_name,
                    d.description host_details,
                    d.location host_address
                FROM events ev
                JOIN users u ON u.user_id = ev.user_id
                LEFT JOIN files f 
                    ON f.table_id = ev.event_id
                    AND f.operation_name = 'events'  
                    AND f.fileinfo = 'banner_image'
                    AND f.deleted_by IS NULL
                LEFT JOIN host_details d
                    ON d.user_id = ev.user_id
                LEFT JOIN files hf 
                    ON hf.table_id = ev.user_id
                    AND hf.operation_name = 'users'  
                    AND hf.fileinfo = 'profile_picture'
                    AND hf.deleted_by IS NULL
                WHERE ev.event_id = ?
                ORDER BY f.created_at DESC, hf.created_at DESC
                LIMIT 1";

        $params[] = $event_id;

        // echo $sql, '<br>';
        // print_r($params);
        // die;

        try {
            $events = DB::query($sql, $params)->fetchAll();

            if (empty($events)) {
                throw new Exception("Event not found!");
            }

            $event = $events[0];
            $event['google_map_location'] = html_entity_decode($event['google_map_location'] ?? '');
            $event['description'] = html_entity_decode($event['description'] ?? '');
            $event['host_details'] = html_entity_decode($event['host_details'] ?? '');

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $event,
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
