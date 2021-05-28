<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Broadcast;
use App\Models\Group;
use App\Enum\BroadcastType;
use App\Enum\BroadcastStatus;
use App\Jobs\BroadcastSms;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team_id = request()->user()->currentTeam->id;
        $groups = Group::where('team_id', $team_id)->get();

        return Inertia::render('Broadcast/Index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;
        if ($currentTeam->api_username === null || $currentTeam->api_password === null || $currentTeam->msisdn_sender === null) {
            return;
        }

        $this->validate($request, [
            'group_id' => 'integer|required',
            'group_title' => 'required|string',
            'sms_text' => 'required|string',
            'broadcast_type' => 'required|string',
            'schedule_time' => 'date|nullable'
        ]);
        $request['team_id'] = $request->user()->currentTeam->id;
        $request['status'] = BroadcastStatus::PENDING;

        if ($request->broadcast_type === BroadcastType::NOW) {
            $request['status'] = BroadcastStatus::PROCESSING;
            $request['schedule_time'] = null;
        }

        $saveBroadcast = Broadcast::create($request->all());

        if ($saveBroadcast->broadcast_type === BroadcastType::NOW) {
            dispatch(new BroadcastSms($saveBroadcast));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function dataGrid(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Broadcast::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->where('team_id', $request->user()->currentTeam->id)->paginate($length);

        return new DataTableCollectionResource($data);
    }
}
