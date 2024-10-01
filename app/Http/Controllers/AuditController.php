<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
// use App\Models\User;
class AuditController extends Controller
{
    public function index()
    {

        $audits = Audit::latest()->get()->groupBy('auditable_type');

        return response()->json([
            'success' => true,
            'data' => $audits
        ], 200);
    }
}
