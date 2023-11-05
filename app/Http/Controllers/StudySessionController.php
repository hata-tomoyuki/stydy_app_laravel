<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudySessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studies = StudySession::select('id', 'subject', 'duration', 'study_date')->get();
        return Inertia::render('Studies/Index', [
            'studies' => $studies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Studies/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(Carbon::parse($request->date)->format('Y-m-d'));
        StudySession::create([
            'user_id' => $request->user()->id,
            'study_date' => Carbon::parse($request->date)->format('Y-m-d'),
            'subject' => $request->subject,
            'duration' => $request->duration,
            'memo' => $request->memo,
        ]);

        return to_route('studies.index')->with([
            'message' => '登録しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studies = StudySession::findOrFail($id);
        return Inertia::render('Studies/Show', [
            'studies' => $studies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $studies = StudySession::findOrFail($id);
        return Inertia::render('Studies/Edit', [
            'studies' => $studies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studies = StudySession::findOrFail($id);

        $studies->subject = $request->subject;
        $studies->duration = $request->duration;
        $studies->memo = $request->memo;

        $studies->save();

        return to_route('studies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
