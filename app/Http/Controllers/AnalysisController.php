<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        // 今週の最初の日と最後の日を取得
        $startDate = Carbon::today()->startOfWeek();
        $endDate = Carbon::today()->endOfWeek();

        $studies = StudySession::betweenDate($startDate, $endDate)
            ->select('id', 'user_id', 'subject', 'duration', 'study_date')
            ->orderBy('study_date', 'asc')
            ->get();

        return Inertia::render('Analysis', [
            'studies' => $studies
        ]);
        return Inertia::render('Analysis');
    }
}
