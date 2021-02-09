<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        $departments = [
            'Finance',
            'ICT',
            'Engineering',
            'Business Development',
            'Research and Development',
            'Operations',
            'Imports',
            'Exports',
            'Human Resource',
            'Maintainance',
            'Services',
            'Marketing',
            'Purchasing',
            'Quality Asurance',
            'Customer Service'
        ];
        DB::table('departments')->truncate();
        $faker = Faker\Factory::create();

        foreach ($departments as $department) {
            $startingDate = $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-15 days');
            $endingDate = $faker->dateTimeBetween($startDate = '+10 days', $endDate = '+20 days');
            $department = Department::create(array(
                'name' => $department,
                'budgetLimit' => $faker->numberBetween($min = 100000, $max = 180000),
                'departmentEmail' => $faker->email,
                'budgetStartDate' => $startingDate->format('Y-m-d'),
                'budgetEndDate' => $endingDate->format('Y-m-d'),
                'companyId' => 1,


            ));
        }
    }
}
