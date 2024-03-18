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
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as datetime')
            ->pluck('datetime')
            ->groupBy(function ($datetime) {
                return Carbon::parse($datetime)->format('Y-m-d H:i:s'); // Raggruppa i dati per giorno e ora
            })
            ->map(function ($item) {
                return $item->count(); // Conta le visite per ogni giorno e ora
            });

        $messagesData = Message::where('apartment_id', $apartmentId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as datetime')
            ->pluck('datetime')
            ->groupBy(function ($datetime) {
                return Carbon::parse($datetime)->format('Y-m-d H:i:s'); // Raggruppa i dati per giorno e ora
            })
            ->map(function ($item) {
                return $item->count(); // Conta i messaggi per ogni giorno e ora
            });

        $labels = $visitsData->keys(); // Ottieni le etichette (giorni) come array

        return response()->json([
            'labels' => $labels,
            'visits' => $visitsData->sortBy(function ($value, $key) {
                return Carbon::parse($key); // Ordina i dati in base alla data
            })->values()->toArray(), // Converti i dati in un array numerico
            'messages' => $messagesData->sortBy(function ($value, $key) {
                return Carbon::parse($key); // Ordina i dati in base alla data
            })->values()->toArray() // Converti i dati in un array numerico
        ]);
    }
}
