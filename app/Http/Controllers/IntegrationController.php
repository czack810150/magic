<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clock;
use App\Employee;
use Carbon\Carbon;

class IntegrationController extends Controller
{
    public function importClocks()
    {
    	//return 'import clock';

    	$maxTransNo = self::maxTransNo();
			if($maxTransNo){
			self::autoAttendanceImport($maxTransNo);
		} else {
			return 'No reference max transaction number.';
		}
    }

    private function maxTransNo(){
		return Clock::max('transNo');
	}
	private function autoAttendanceImport($maxTransNo)
	{
		$attendance = json_decode(self::shiftAutoPull());
		if(count($attendance->list[0]->record) >= 1000){
			$return['status'] = 'warning';
			$return['message'] = "Failed. Cannot read more than 1000 records.";
			echo json_encode($return);
			return false;
		}
		$return['Current Max Transaction #'] = $maxTransNo;
		if($attendance->list[0]->result == "ok") {
		foreach($attendance->list[0]->record as $r){
			if($r->TransNo){
				switch ($r->Location){
					case 'Store1':
					$data['location'] = 1;
					break;
					case 'Store2':
					$data['location'] = 2;
					break;
					case 'Store3':
					$data['location'] = 3;
					break;
					case 'Store4':
					$data['location'] = 4;
					break;
					case 'Store5':
					$data['location'] = 5;
					break;
				}
				$employee = Employee::where('employeeNumber',$r->EmployeeRemark)->first();
				if($employee){
				$data['employee_id'] = $employee->id;
				$data['clockIn'] = $r->ClockIn;
				$data['clockOut'] = $r->ClockOut;
				$data['transNo'] = $r->TransNo;
				$status = self::insertClock($data);
				$return['Processed up to'] = $data['transNo'];
				$return['Attendence Import'] = $status;
				} else {
				$return['Processed up to'] = $r->TransNo;
				$return['No employee found for '] = $r->EmployeeRemark;
				$return['Attendence Import'] = 'not imported';
				}
				
				
			}
		}
			$return['status'] = 'success';
			$return['message'] = 'AutoPuller executed normally!';
			echo json_encode($return);
			return true;
		} else {
			$return['status'] = 'error';
			$return['message'] = 'Bad result';
			echo json_encode($return);
			return false;
				}	
	}

	private function insertClock($data)
	{
		if($data['clockOut'] != '1899-12-30 00:00:00' && self::checkRecord($data['transNo'])) {
			$clock = new Clock;
			$clock->location_id = $data['location'];
			$clock->employee_id = $data['employee_id'];
			$clock->clockIn = $data['clockIn'];
			$clock->clockOut = $data['clockOut'];
			$clock->transNo = $data['transNo'];
			$clock->save();
			return 'Attendence insertion success';
		}	
		return 'No attendance insertion';
	}
	private function checkRecord($transNo)
	{
		if( sizeof(Clock::where('transNo',$transNo)->get()) ){
			return false;
		} else {
			return true;
		}
	}

	private function shiftAutoPull()
	{	
		$now = Carbon::now();
		$dateTo = $now->toDateString();
		$dateFrom = $now->subDays(7)->toDateString();
		$req = '{"CompanyCode" : "MAGIC NOODLE", "UserName" : "API", "UserPassword" : "MynJuSh4zC8QRcd","list":[{"DateFrom":"'.$dateFrom.'","DateTo":"'.$dateTo.'"}]}';
		$url = 'https://magicnoodlehq.dd.mrsdigi.com/DigiCard.php/ajax/Attendance';
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
			   'content' => $req
		       // 'content' => http_build_query($req)
		    ),
		    'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false
		    )
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error */ }
		return $result;	
	}
}
