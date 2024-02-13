<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
  
        $data = Teacher::all();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($user) {
                    // Assuming 'profile_picture' is the media field
                    return $user->getFirstMediaUrl('image') != null ? $user->getFirstMediaUrl('image') : asset('assets/assets/avatars/Admin.svg') ;
                })
                ->addColumn('action', function ($row) {
           
                  
                    $btn = '<button   data-toggle="modal" data-target="#editTeacher'.$row->id .'"  class="btn btn-sm btn-warning">تعديل</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.teachers.index',compact('data'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required'
        ]);
        $data = $request->only(['name','phone','email']);
        $teacher = Teacher::findOrFail($id);
        $teacher->update($data);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $teacher->addMediaFromRequest('image')->toMediaCollection('image');
        }
        return back()->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
