<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Employee;
class EmployeeController extends Controller
{


    public function index()
    {
        $employees=User::Role('employee')->get();
        return view('employees.index', compact( 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    public function store(StoreUserRequest $request)
    {
        $employee=User::create($request->validated());
        $employee->assignRole('employee');
        $employee->image='/img/users/default.png';
        $employee->save();
        return redirect()->route('employees.index')->with('success', value: 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $employee=User::find($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
      $employee=User::find($id);
      $employee->update($request->validated());

      return redirect()->route('employees.index')->with('success', 'Employee Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('employees.index')->with('success', 'Employee Deleted successfully!');;
    }




}
