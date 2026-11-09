<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HrmsController extends Controller
{
    /**
     * HRMS Dashboard Overview
     */
    public function dashboard()
    {
        $today = now()->toDateString();

        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $onLeaveEmployees = Employee::where('status', 'on_leave')->count();
        $totalDepartments = Department::count();

        $todayPresent = Attendance::where('date', $today)->whereIn('status', ['present', 'late', 'half_day'])->count();
        $attendanceRate = $totalEmployees > 0 ? round(($todayPresent / $totalEmployees) * 100) : 0;

        $monthlyPayroll = Payroll::where('month', now()->format('F Y'))->sum('net_salary');

        $pendingLeaves = Leave::with('employee')->where('status', 'pending')->latest()->take(5)->get();
        $recentEmployees = Employee::with('department')->latest()->take(5)->get();
        $todayAttendances = Attendance::with('employee.department')->where('date', $today)->latest()->take(6)->get();

        return view('admin.hrms.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'onLeaveEmployees',
            'totalDepartments',
            'todayPresent',
            'attendanceRate',
            'monthlyPayroll',
            'pendingLeaves',
            'recentEmployees',
            'todayAttendances'
        ));
    }

    /**
     * Employees Directory
     */
    public function employees(Request $request)
    {
        $query = Employee::with('department');

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('employee_id', 'like', "%{$s}%")
                  ->orWhere('designation', 'like', "%{$s}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $employees = $query->orderBy('name')->paginate(10)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('admin.hrms.employees.index', compact('employees', 'departments'));
    }

    /**
     * Create Employee Form
     */
    public function createEmployee()
    {
        $departments = Department::orderBy('name')->get();
        $employee = new Employee();
        return view('admin.hrms.employees.form', compact('employee', 'departments'));
    }

    /**
     * Store New Employee
     */
    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:50|unique:employees,employee_id',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:employees,email',
            'phone' => 'nullable|string|max:30',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,on_leave,terminated',
            'address' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:100',
            'avatar_file' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = time() . '_' . Str::slug($request->input('name')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/team'), $filename);
            $validated['avatar'] = '/assets/images/team/' . $filename;
        } else {
            $validated['avatar'] = '/assets/images/team/team-1.jpg';
        }

        Employee::create($validated);

        return redirect()->route('admin.hrms.employees.index')->with('success', 'Employee onboarded successfully.');
    }

    /**
     * Edit Employee Form
     */
    public function editEmployee(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.hrms.employees.form', compact('employee', 'departments'));
    }

    /**
     * Update Employee Record
     */
    public function updateEmployee(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:50|unique:employees,employee_id,' . $employee->id,
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:30',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,on_leave,terminated',
            'address' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:100',
            'avatar_file' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = time() . '_' . Str::slug($request->input('name')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/team'), $filename);
            $validated['avatar'] = '/assets/images/team/' . $filename;
        }

        $employee->update($validated);

        return redirect()->route('admin.hrms.employees.index')->with('success', 'Employee profile updated.');
    }

    /**
     * Delete Employee
     */
    public function destroyEmployee(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.hrms.employees.index')->with('success', 'Employee record removed.');
    }

    /**
     * Departments List & Management
     */
    public function departments()
    {
        $departments = Department::withCount('employees')->orderBy('name')->get();
        return view('admin.hrms.departments.index', compact('departments'));
    }

    /**
     * Store Department
     */
    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string|max:300',
            'manager_name' => 'nullable|string|max:100',
        ]);

        Department::create($validated);

        return redirect()->route('admin.hrms.departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Delete Department
     */
    public function destroyDepartment(Department $department)
    {
        if ($department->employees()->count() > 0) {
            return back()->with('error', 'Cannot delete department with active assigned employees.');
        }

        $department->delete();
        return redirect()->route('admin.hrms.departments.index')->with('success', 'Department removed.');
    }

    /**
     * Attendance Management
     */
    public function attendance(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $employees = Employee::with(['attendances' => function ($q) use ($date) {
            $q->where('date', $date);
        }, 'department'])->orderBy('name')->get();

        $stats = [
            'present' => Attendance::where('date', $date)->where('status', 'present')->count(),
            'late' => Attendance::where('date', $date)->where('status', 'late')->count(),
            'absent' => Attendance::where('date', $date)->where('status', 'absent')->count(),
            'on_leave' => Attendance::where('date', $date)->where('status', 'on_leave')->count(),
        ];

        return view('admin.hrms.attendance.index', compact('employees', 'date', 'stats'));
    }

    /**
     * Mark Attendance
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:present,late,half_day,absent,on_leave',
            'check_in' => 'nullable|string',
            'check_out' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Attendance::updateOrCreate(
            ['employee_id' => $request->input('employee_id'), 'date' => $request->input('date')],
            [
                'status' => $request->input('status'),
                'check_in' => $request->input('check_in'),
                'check_out' => $request->input('check_out'),
                'notes' => $request->input('notes'),
            ]
        );

        return back()->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Leave Requests
     */
    public function leaves(Request $request)
    {
        $query = Leave::with('employee.department');

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $leaves = $query->latest()->paginate(10)->withQueryString();

        return view('admin.hrms.leaves.index', compact('leaves'));
    }

    /**
     * Update Leave Status (Approve / Reject)
     */
    public function updateLeaveStatus(Request $request, Leave $leave)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        $leave->update([
            'status' => $request->input('status'),
            'admin_remarks' => $request->input('admin_remarks'),
        ]);

        // If approved, update employee status to on_leave if current date is within range
        if ($request->input('status') === 'approved') {
            $today = now()->toDateString();
            if ($today >= $leave->start_date->toDateString() && $today <= $leave->end_date->toDateString()) {
                $leave->employee->update(['status' => 'on_leave']);
            }
        }

        return back()->with('success', 'Leave request marked as ' . ucfirst($request->input('status')) . '.');
    }

    /**
     * Payroll Management
     */
    public function payroll(Request $request)
    {
        $month = $request->input('month', now()->format('F Y'));
        $payrolls = Payroll::with('employee.department')->where('month', $month)->get();

        $totalDisbursed = $payrolls->where('status', 'paid')->sum('net_salary');
        $totalPending = $payrolls->where('status', '!=', 'paid')->sum('net_salary');

        return view('admin.hrms.payroll.index', compact('payrolls', 'month', 'totalDisbursed', 'totalPending'));
    }

    /**
     * Process/Pay Payroll Record
     */
    public function updatePayrollStatus(Request $request, Payroll $payroll)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,paid',
            'payment_method' => 'nullable|string',
        ]);

        $payroll->update([
            'status' => $request->input('status'),
            'payment_method' => $request->input('payment_method', $payroll->payment_method),
            'payment_date' => $request->input('status') === 'paid' ? now()->toDateString() : $payroll->payment_date,
        ]);

        return back()->with('success', 'Payroll record updated.');
    }

    /**
     * Single Payslip View
     */
    public function payslip(Payroll $payroll)
    {
        $payroll->load('employee.department');
        return view('admin.hrms.payroll.payslip', compact('payroll'));
    }
}

