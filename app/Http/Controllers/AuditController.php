<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
// use App\Models\User;
class AuditController extends Controller
{
    public function index()
    {

        if(auth()->user()->email !== "admin1@admin.com"){
            return response()->json([
                "message"=> "You are not authorized",
                "status" => false
            ], 401);
        }

        $audits = Audit::latest()->get()->groupBy('auditable_type');

        return response()->json([
            'success' => true,
            'data' => $audits
        ], 200);
    }
}
