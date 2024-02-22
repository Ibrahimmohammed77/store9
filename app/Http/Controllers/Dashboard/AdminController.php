<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $admins = Admin::paginate();
            return view('dashboard.admins.index')
                ->with([
                    'admins' => $admins,
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admins.create')
            ->with([
                'roles'=>Role::all(),
                'admin' => new Admin(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);
        $admin= Admin::create($request->all());
        $admin->roles()->attach($request->roles);
        // Admin::adminability($request, $admin);
        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin Created Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('dashboard.admins.show')
            ->with(['admin' => $admin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles=Role::all();
        $admin_roles=$admin->roles()->pluck('id')->toArray();
        // dd($admin_roles);
        
        return view('dashboard.admins.edit')
            ->with([
                'roles'=>$roles,
                'admin' => $admin,
            'admin_roles' => $admin_roles
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);
        $admin->update($request->all());
        $admin()->roles()->sync($request->roles);
        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin Updated Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin Deleted Success');
    }
}
