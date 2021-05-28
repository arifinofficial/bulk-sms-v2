<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Imports\MemberImport;
use Illuminate\Support\Facades\Redirect;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Groups/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Groups/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required|string',
                'file'  => 'required|mimes:xlsx,xls,csv,txt'
            ],
            [
                'file.mimes' => 'Unsupported file format.'
            ]
        );

        $request['team_id'] = $request->user()->currentTeam->id;

        $originalFileName = $request->file->getClientOriginalName();
        $extensionFile = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $fileName = Str::slug(pathinfo($originalFileName, PATHINFO_FILENAME) . "-" . time(), "-") . "." . $extensionFile;

        $saveFile = $request->file->storeAs('excel', $fileName);

        DB::beginTransaction();
        try {
            $storagePath = storage_path('app/' . $saveFile);
            $headings = (new HeadingRowImport)->toArray($storagePath);
            $request['meta'] = $headings[0][0];

            $group = Group::create($request->except(['file']));
            $groupId = $group->id;

            Excel::import(new MemberImport($groupId), $storagePath);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
            DB::rollback();
        }

        return Redirect::route('group-management.index');
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
        $groupModel = Group::findOrFail($id);

        return Inertia::render('Groups/Edit', compact('groupModel'));
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
        $this->validate($request, [
            'title' => 'required|string'
        ]);

        $groupModel = Group::findOrFail($id);
        $groupModel->update($request->all());

        return Redirect::route('group-management.index');
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

        $query = Group::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->where('team_id', $request->user()->currentTeam->id)->paginate($length);

        return new DataTableCollectionResource($data);
    }
}
