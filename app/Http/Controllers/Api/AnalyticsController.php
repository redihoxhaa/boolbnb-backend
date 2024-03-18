<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Visit;
use Illuminate\Http\Request;

use Carbon\Carbon;

class AnalyticsController extends Controller
{
    // Modifica il controller API per formattare i dati correttamente
    public function getAnalyticsData(Request $request)
    {
        $apartmentId = $request->input('apartmentId');
        $startDate = Carbon::createFromFormat('Y-m-d', $request->input('startDate'))->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->input('endDate'))->endOfDay();

        $visitsData = Visit::where('apartment_id', $apartmentId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $messagesData = Message::where('apartment_id', $apartmentId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        return response()->json([
            'visits' => $visitsData,
            'messages' => $messagesData
        ]);
    }
}
