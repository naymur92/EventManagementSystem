<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;

class EventApiController extends Controller
{
    public function getEventSchedules(Request $request)
    {
        $data = $request->all();
        $limit = (int) $data['limit'] ?? '';

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
            // $params[] = (int) $limit;
        }

        $schedules = DB::query($sql, $params)->fetchAll();

        Response::json($schedules, 200);
    }
}
