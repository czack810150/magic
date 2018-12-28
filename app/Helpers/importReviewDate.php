<?php
namespace App\Helpers;

use App\Employee;
use App\EmployeeReview;
use Carbon\Carbon;

class ImportReviewDate
{
	public static function import()
	{
		
		$employees = Employee::with(['review','job_location','promotion'])->get();
		foreach($employees as $employee)
		{
			print $employee->name."\n";

			foreach($employee->job_location as $job_location)
			{
				print $job_location->job->rank."\n";

				if(!EmployeeReview::where('employee_id',$employee->id)->where('reviewDate',$job_location->review)->get()->count()){

					if(Carbon::parse($job_location->review)->year == 2019){
						$nextReview = $job_location->review;
					} else {
						$nextReview = Carbon::parse($job_location->review)->addDays(180)->toDateString();
					}

					EmployeeReview::create([
					'employee_id' => $employee->id,
					'location_id' => $job_location->location_id,
					'job_id' => $job_location->job_id,
					'notified' => true,
					'reviewed' => true,
					'exam_id' => null,
					'pass' => false,
					'reviewDate' => $job_location->review,
					'nextReview' => $nextReview,
					'manager_id' => null,
					'manager_score' => null,
					'self_score' => null,
					'self_data' => null,
					'performance' => null,
					'hr_score' => false,
					'org_score' => false,
					'result' => true,
					'description' => 'imported from job_location',
					'verified' => true,
					'manager_note' => 'imported from job_location',
					'self_note' => null,
				]);
				}
			}

			foreach($employee->promotion as $promotion)
			{
				print $promotion->status."\n";
				if(!EmployeeReview::where('employee_id',$employee->id)->where('reviewDate',$promotion->created_at->toDateString())->get()->count() && $promotion->status === 'approved' ){

					if($promotion->created_at->year == 2019){
						$nextReview = $promotion->created_at->toDateString();
					} else {
						$nextReview = $promotion->created_at->addDays(180)->toDateString();
					}

					EmployeeReview::create([
					'employee_id' => $employee->id,
					'location_id' => $promotion->newLocation,
					'job_id' => $promotion->newJob,
					'notified' => true,
					'reviewed' => true,
					'exam_id' => null,
					'pass' => false,
					'reviewDate' => $promotion->created_at->toDateString(),
					'nextReview' => $nextReview,
					'manager_id' => null,
					'manager_score' => null,
					'self_score' => null,
					'self_data' => null,
					'performance' => null,
					'hr_score' => false,
					'org_score' => false,
					'result' => true,
					'description' => 'imported from job_promotions',
					'verified' => true,
					'manager_note' => 'imported from job_promotions',
					'self_note' => null,
					]);
				}
				
			}

			print "\n";
		}
		return 'All finished.';
	}
}