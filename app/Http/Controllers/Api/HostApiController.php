<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use Exception;

class HostApiController extends Controller
{

    /**
     * Get Host Users API
     *
     * @param Request $request
     * @return void
     */
    public function getHostUsers(Request $request): void
    {
        $request->setSanitizationRules([
            'limit' => ['integer']
        ]);

        $data = $request->all();
        $limit = $data['limit'] ?? 500; // default limit is 500

        $params = array();
        $sql = "SELECT 
                    u.user_id AS host_id, 
                    u.name,
                    CONCAT('/uploads/', f.filepath, '/', f.filename) profile_picture,
                    d.description, 
                    d.location
                FROM users u
                LEFT JOIN files f 
                    ON f.table_id = u.user_id 
                    AND f.operation_name = 'users' 
                    AND f.fileinfo = 'profile_picture'
                    AND f.deleted_by IS NULL
                LEFT JOIN host_details d 
                    ON d.user_id = u.user_id
                WHERE u.type = 2
                    AND u.status = ?
                ORDER BY u.name, f.created_at DESC";

        $params[] = 1;

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        try {
            $hostUsers = DB::query($sql, $params)->fetchAll();

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $hostUsers,
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
