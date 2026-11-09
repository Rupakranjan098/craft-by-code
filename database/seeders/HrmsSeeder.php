<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use Illuminate\Database\Seeder;

class HrmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Departments
        $deptData = [
            ['name' => 'Software Engineering', 'code' => 'ENG', 'description' => 'Full-stack web, mobile, and backend development squads.', 'manager_name' => 'Alexander Hayes'],
            ['name' => 'UI/UX Design', 'code' => 'DSN', 'description' => 'Product design, user research, wireframing and design systems.', 'manager_name' => 'Maya Lin'],
            ['name' => 'Quality Assurance & Testing', 'code' => 'QA', 'description' => 'Automated regression, performance and security testing.', 'manager_name' => 'Rohit Nanda'],
            ['name' => 'Cloud & DevOps Infrastructure', 'code' => 'OPS', 'description' => 'CI/CD pipelines, Kubernetes clusters, and AWS architecture.', 'manager_name' => 'Chloe Bennett'],
            ['name' => 'HR & Operations', 'code' => 'HRO', 'description' => 'Talent acquisition, employee wellness, and corporate ops.', 'manager_name' => 'Sarah Vance'],
        ];

        $depts = [];
        foreach ($deptData as $d) {
            $depts[$d['code']] = Department::updateOrCreate(['code' => $d['code']], $d);
        }

        // 2. Employees
        $empData = [
            [
                'employee_id' => 'EMP-101',
                'name' => 'David Morales',
                'email' => 'david.morales@craftbycode.com',
                'phone' => '+1 (415) 301-4455',
                'department_id' => $depts['ENG']->id,
                'designation' => 'Senior Full-Stack Engineer',
                'joining_date' => '2023-03-15',
                'salary' => 95000.00,
                'status' => 'active',
                'avatar' => '/assets/images/team/team-1.jpg',
                'address' => '742 Evergreen Terrace, San Francisco, CA',
                'emergency_contact' => '+1 (415) 888-9900 (Spouse)',
            ],
            [
                'employee_id' => 'EMP-102',
                'name' => 'Sophia Chen',
                'email' => 'sophia.chen@craftbycode.com',
                'phone' => '+1 (415) 301-8899',
                'department_id' => $depts['DSN']->id,
                'designation' => 'Lead Product Designer',
                'joining_date' => '2023-06-01',
                'salary' => 88000.00,
                'status' => 'active',
                'avatar' => '/assets/images/team/team-2.jpg',
                'address' => '120 Market St, Apt 4B, San Francisco, CA',
                'emergency_contact' => '+1 (415) 555-1212 (Father)',
            ],
            [
                'employee_id' => 'EMP-103',
                'name' => 'Marcus Rivera',
                'email' => 'marcus.rivera@craftbycode.com',
                'phone' => '+1 (415) 301-7711',
                'department_id' => $depts['ENG']->id,
                'designation' => 'Backend API Architect',
                'joining_date' => '2022-11-10',
                'salary' => 105000.00,
                'status' => 'active',
                'avatar' => '/assets/images/team/team-3.jpg',
                'address' => '88 King St, San Francisco, CA',
                'emergency_contact' => '+1 (415) 444-3322 (Brother)',
            ],
            [
                'employee_id' => 'EMP-104',
                'name' => 'Elena Rostova',
                'email' => 'elena.rostova@craftbycode.com',
                'phone' => '+1 (415) 301-2244',
                'department_id' => $depts['OPS']->id,
                'designation' => 'DevOps Cloud Specialist',
                'joining_date' => '2024-01-20',
                'salary' => 92000.00,
                'status' => 'active',
                'avatar' => '/assets/images/team/team-4.jpg',
                'address' => '456 Mission Bay Blvd, San Francisco, CA',
                'emergency_contact' => '+1 (415) 777-6655 (Mother)',
            ],
            [
                'employee_id' => 'EMP-105',
                'name' => 'James Wilson',
                'email' => 'james.wilson@craftbycode.com',
                'phone' => '+1 (415) 301-9933',
                'department_id' => $depts['QA']->id,
                'designation' => 'QA Automation Lead',
                'joining_date' => '2024-04-12',
                'salary' => 82000.00,
                'status' => 'on_leave',
                'avatar' => '/assets/images/testimonials/avatar-1.jpg',
                'address' => '321 Harrison St, San Francisco, CA',
                'emergency_contact' => '+1 (415) 222-1100 (Spouse)',
            ],
            [
                'employee_id' => 'EMP-106',
                'name' => 'Aria Patel',
                'email' => 'aria.patel@craftbycode.com',
                'phone' => '+1 (415) 301-6677',
                'department_id' => $depts['HRO']->id,
                'designation' => 'People & Culture Manager',
                'joining_date' => '2023-09-01',
                'salary' => 80000.00,
                'status' => 'active',
                'avatar' => '/assets/images/testimonials/avatar-2.jpg',
                'address' => '500 Howard St, San Francisco, CA',
                'emergency_contact' => '+1 (415) 999-0011 (Sister)',
            ]
        ];

        $employees = [];
        foreach ($empData as $e) {
            $employees[$e['employee_id']] = Employee::updateOrCreate(['employee_id' => $e['employee_id']], $e);
        }

        // 3. Attendances for Today
        $today = now()->toDateString();
        Attendance::updateOrCreate(['employee_id' => $employees['EMP-101']->id, 'date' => $today], [
            'check_in' => '09:02:00',
            'check_out' => '18:05:00',
            'status' => 'present',
            'notes' => 'On time, logged via biometric portal'
        ]);
        Attendance::updateOrCreate(['employee_id' => $employees['EMP-102']->id, 'date' => $today], [
            'check_in' => '09:14:00',
            'check_out' => '18:00:00',
            'status' => 'present',
            'notes' => 'Design sprint review'
        ]);
        Attendance::updateOrCreate(['employee_id' => $employees['EMP-103']->id, 'date' => $today], [
            'check_in' => '09:45:00',
            'check_out' => '18:30:00',
            'status' => 'late',
            'notes' => 'Late by 45 mins due to transit delay'
        ]);
        Attendance::updateOrCreate(['employee_id' => $employees['EMP-104']->id, 'date' => $today], [
            'check_in' => '08:55:00',
            'check_out' => null,
            'status' => 'present',
            'notes' => 'Server maintenance shift'
        ]);
        Attendance::updateOrCreate(['employee_id' => $employees['EMP-105']->id, 'date' => $today], [
            'check_in' => null,
            'check_out' => null,
            'status' => 'on_leave',
            'notes' => 'Approved medical leave'
        ]);
        Attendance::updateOrCreate(['employee_id' => $employees['EMP-106']->id, 'date' => $today], [
            'check_in' => '09:05:00',
            'check_out' => '18:10:00',
            'status' => 'present',
            'notes' => 'Conducting candidate interviews'
        ]);

        // 4. Sample Leaves
        Leave::updateOrCreate([
            'employee_id' => $employees['EMP-105']->id,
            'start_date' => now()->toDateString(),
        ], [
            'leave_type' => 'Sick Leave',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'days' => 3,
            'reason' => 'Viral flu and doctor recommended 3 days of rest.',
            'status' => 'approved',
            'admin_remarks' => 'Approved by Alexander Hayes. Medical note received.',
        ]);

        Leave::updateOrCreate([
            'employee_id' => $employees['EMP-101']->id,
            'start_date' => now()->addDays(5)->toDateString(),
        ], [
            'leave_type' => 'Annual Paid Time Off',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(9)->toDateString(),
            'days' => 5,
            'reason' => 'Family vacation to Lake Tahoe.',
            'status' => 'pending',
            'admin_remarks' => null,
        ]);

        // 5. Sample Payroll Records
        $currentMonth = now()->format('F Y');
        foreach ($employees as $emp) {
            $basic = $emp->salary / 12;
            $allowance = 500.00;
            $deductions = 250.00;
            $net = $basic + $allowance - $deductions;

            Payroll::updateOrCreate([
                'employee_id' => $emp->id,
                'month' => $currentMonth,
            ], [
                'basic_salary' => $basic,
                'allowance' => $allowance,
                'deductions' => $deductions,
                'net_salary' => $net,
                'payment_date' => now()->startOfMonth()->addDays(28)->toDateString(),
                'payment_method' => 'Bank Wire Transfer',
                'status' => 'processed',
            ]);
        }
    }
}

