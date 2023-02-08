<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::all();
        if ($employees) {
            return response([
                'status' => 200,
                'message' => 'Data Fetched',
                'data' => EmployeeResource::collection($employees),
            ], 200);
        } else {
            return response([
                'status' => 500,
                'message' => 'Some Error Ocurred While Fetching the data',
                // 'data' => EmployeeResource::collection($employees),
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'age' => 'required|max:50',
            'job' => 'required|max:50',
            'salary' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'Validation Error'
            ]);
        }

        $employee = Employee::create($data);
        return response([
            'employee' => new
                EmployeeResource($employee),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
        return response([
            'status' => 200,
            'message' => 'Employee Found',
            'data' => new
                EmployeeResource($employee),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
        $employee->update($request->all());

        return response(['employee' => new
            EmployeeResource($employee), 'message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $employee->delete();

        return response(['message' => 'Employee deleted']);
    }
}
