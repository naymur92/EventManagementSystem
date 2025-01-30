<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use Exception;

class EventApiController extends Controller
{
    public function getEventSchedules(Request $request)
    {
        $request->setSanitizationRules([
            'limit' => ['integer']
        ]);

        $data = $request->all();
        $limit = $data['limit'] ?? '';

        $params = array();
        $sql = "SELECT start_time
                FROM events
                WHERE start_time >= ?
                    AND status = ?
                ORDER BY start_time ASC";

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
                'message' => "Failed",
                'data' => array(),
            ), 400);
        }
    }
}
