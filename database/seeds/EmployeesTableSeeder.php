<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levelOne = factory(App\Employee::class)->create();
        $levelTwo = factory(App\Employee::class, 5)->create(['parent_id' => $levelOne->id]);
        $levelThree = factory(App\Employee::class, 50)
            ->create()
            ->each(function($employee) use ($levelTwo) {
                $employee->parent_id = $levelTwo->random()->id;
                $employee->save();
            });
        $levelFour = factory(App\Employee::class, 500)
            ->create()
            ->each(function($employee) use ($levelThree) {
                $employee->parent_id = $levelThree->random()->id;
                $employee->save();
            });
        $levelFive = factory(App\Employee::class, 5000)
            ->create()
            ->each(function($employee) use ($levelFour) {
                $employee->parent_id = $levelFour->random()->id;
                $employee->save();
            });
    }
}
