<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudySession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $studies = [];

        if ($request->type === 'perWeek') {
            Carbon::setWeekStartsAt(Carbon::SUNDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);

            // 今週の最初の日と最後の日を取得
            $startDate = Carbon::today()->startOfWeek();
            $endDate = Carbon::today()->endOfWeek();

            $studies = StudySession::betweenDate($startDate, $endDate)
                ->select('id', 'user_id', 'subject', 'duration', 'study_date')
                ->orderBy('study_date', 'asc')
                ->get();
        }

        if ($request->type === 'perMonth') {
            // 今月の最初の日と最後の日を取得
            $startDate = Carbon::today()->startOfMonth();
            $endDate = Carbon::today()->endOfMonth();

            // 学習データを取得
            $studies = StudySession::whereBetween('study_date', [$startDate, $endDate])
                ->select('id', 'user_id', 'subject', 'duration', 'study_date')
                ->orderBy('study_date', 'asc')
                ->get();
        }


        return response()->json([
            'type' => $request->type,
            'studies' => $studies
        ], Response::HTTP_OK);
    }
}
