<?php

// app/Helpers/CustomHelpers.php


/* use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating; */

function perpagerecords()
{
	$pageArr = [10 => 10, 20 => 20, 25 => 25, 50 => 50, 100 => 100];
	return $pageArr;
}
function getShippingUnitPrice()
{
    $localUrls = ['http://127.0.0.1:8000', 'http://13.49.251.219'];
    
    return in_array(config('app.url'), $localUrls) ? 5.00 : 10.00;
}

/*
function checkPermission($permissions)
{
	if(auth()->user() && auth()->user()->role) {
		$userAccess = getMyPermission(auth()->user()->role->keyword);
		foreach ($permissions as $key => $value) {
			if ($value == $userAccess) {
				return true;
			}
		}
	}
	return false;
}

function getMyPermission($keyword)
{
	switch ($keyword) {
		case "admin":
			return 'admin';
			break;
		case "patient":
			return 'patient';
			break;
		case "doctor":
			return 'doctor';
			break;
		case "nurses":
			return 'nurses';
			break;
		case "surgeon":
			return 'surgeon';
			break;
		case "pharmacy":
			return 'pharmacy';
			break;
		case "hospital":
			return 'hospital';
			break;
		case "clinic":
			return 'clinic';
			break;
		case "service_cente":
			return 'service_cente';
			break;
		case "healthy_cab":
			return 'healthy_cab';
			break;
		case "manager":
			return 'manager';
			break;
		case "accountant":
			return 'accountant';
			break;
		case "agent":
			return 'agent';
			break;
		case "diagnostics":
			return 'diagnostics';
			break;
	}
} */

function arrayToString($array)
{
	if (!empty($array)) {
		$array = array_filter($array);
		$string = implode(',', $array);
		return $string;
	} else {
		return false;
	}
}

function stringToArray($string)
{
	if (!empty($string)) {
		$string = trim($string);
		$array = explode(',', $string);
		return $array;
	} else {
		return false;
	}
}

function getStatus($value, $message)
{
	switch ($value) {
		case 0:
			return '<span class="badge badge-pill badge-warning">Pending</span>';
			break;
		case 1:
			return '<span class="badge badge-pill badge-success">Accepted</span>';
			break;
		case 2:
			return '<span class="badge badge-pill badge-danger" data-toggle="tooltip" data-placement="top" title="' . $message . '">Rejected</span>';
			break;
		case 3:
			return '<span class="badge badge-pill badge-info">Blocked</span>';
			break;
		default:
			return '<span class="badge badge-pill badge-warning">Pending</span>';
			break;
	}
}


function getAppointmentStatus($value)
{
	switch ($value) {
		case 'pending':
			return '<span class="badge badge-pill badge-warning">Pending</span>';
			break;
		case 'create':
			return '<span class="badge badge-pill badge-primary">Created</span>';
			break;
		case 'attempt':
			return '<span class="badge badge-pill badge-info" >Attempt</span>';
			break;
		case 'completed':
			return '<span class="badge badge-pill badge-success">Completed</span>';
			break;
		case 'cancelled':
			return '<span class="badge badge-pill badge-danger">Cancelled</span>';
			break;
		default:
			return '<span class="badge badge-pill badge-warning">Pending</span>';
			break;
	}
}

function getWarehouseTypes()
{
	return [
		'Supplier' => 'Supplier',
		'Third-party' => 'Third-party',
		'Client' => 'Client',
		'Own' => 'Own',
		'Affiliate' => 'Affiliate',
	];
}
function getUserProfileStatus($value)
{
	switch ($value) {
		case 1:
			return 'Your Profile Is Under Verification.';
			break;
		case 2:
			return 'Your profile has been approved.';
			break;
		case 3:
			return 'Your profile has been rejected.';
			break;
		default:
			return 'Lets create your dedicated profile.';
			break;
	}
}

/* function userProfileStatusMessage() {

	$verified_column = '';
	if(Session::get('panel') == 'doctor'){
		$verified_column = 'as_doctor_verified';
	} elseif(Session::get('panel') == 'agent') {
		$verified_column = 'as_agent_verified';
	} elseif(Auth::user()->role->name == 'Pharmacy') {
		$verified_column = 'as_pharmacy_verified';
	} elseif(Auth::user()->role->name == 'Clinic') {
		$verified_column = 'is_clinic_verified';
	} elseif(Auth::user()->role->name == 'Diagnostics') {
		$verified_column = 'as_diagnostics_verified';
	} elseif(Auth::user()->role->name == 'Hospital') {
		$verified_column = 'is_hospital_verified';
	}

	if(Auth::user()->locality == null) {
		//return 'Please fill up your profile first.';
	} elseif(Auth::user()->$verified_column != 2 && Session::get('panel') != 'patient') {
		return 'Please verify document first.';
	}

	return false;
} */

function getRoles($value)
{
	switch ($value) {
		case 0:
			return '<i title="Admin" class="fas fa-user-cog"></i>';
			break;
		case 1:
			return '<i title="Admin" class="fas fa-user-cog"> Admin</i>';
			break;
		case 2:
			return '<i title="Patient" class="fas fa-user-injured"> Patient</i>';
			break;
		case 3:
			return '<i title="Doctor" class="fas fa-user-md"> Doctor</i>';
			break;
		case 4:
			return '<i title="Nurse" class="fas fa-user-nurse"> Nurse</i>';
			break;
		case 5:
			return '<i title="Surgeon" class="fas fa-user-md"> Surgeon</i>';
			break;
		case 6:
			return '<i title="Pharmacy" class="fas fa-hand-holding-medical"> Pharmacy</i>';
			break;
		case 7:
			return '<i title="Hospital" class="fas fa-hospital-alt"> Hospital</i>';
			break;
		case 8:
			return '<i title="Clinic" class="fas fa-clinic-medical"> Clinic</i>';
			break;
		case 9:
			return '<i title="Service center" class="fas fa-headset"> Service center</i>';
			break;
		case 10:
			return '<i title="Healthy cab" class="fas fa-taxi"> Healthy cab</i>';
			break;
		default:
			return '<span class="badge badge-pill badge-warning">default</span>';
			break;
	}
}

/* function getRoleId($keyword)
{
	$role_id = UserRole::where('keyword', $keyword)->get('id')->first();
	return $role_id->id;
} */

/*start-function of check permission based on user role*/
/* function isAuthorize($route_name)
{
	if (Auth::user()->role->keyword == "superadmin") {
		return true;
	}
	$check = Permission::where('role_id', Auth::user()->role->id)->whereHas('route', function ($q) use ($route_name) {
		$q->where('route_name', $route_name);
	})->first();
	if ($check && $check->status) {
		return true;
	}
	return false;
} */

/* function checkAuthorization($route_name)
{
	if (Auth::user()->role->keyword == "superadmin") {
		return true;
	}
	if ($route_name) {
		$check = Permission::where('role_id', Auth::user()->role->id)->whereHas('route', function ($q) use ($route_name) {
			$q->where('route_name', $route_name);
		})->first();
		if ($check && $check->status) {
			return true;
		}
	}
	return false;
} */

/* function isModuleVisible($routes)
{
	if (Auth::user()->role->keyword == "superadmin") {
		return true;
	}
	if (!empty($routes)) {
		$statusArray = [];
		$status = false;
		foreach ($routes as $key => $route_name) {
			$check = Permission::where('role_id', Auth::user()->role->id)->whereHas('route', function ($q) use ($route_name) {
				$q->where('route_name', $route_name);
			})->first();
			if ($check && $check->status) {
				$status = true;
			}
		}
		if ($status) {
			return true;
		} else {
			return false;
		}
	}
	return false;
} */
/*end-function of check permission based on user role*/

/* Doctor Module */

/* Function for check the doctor's as dedicated profile */
/* function dedicateProfileSteps()
{
	$userDetails = Auth::user()->detail;
	$step = 1;
	if (!empty($userDetails)) {
		if (!empty($userDetails->degree) || !empty($userDetails->collage_or_Institute) || !empty($userDetails->year_of_completion) || !empty($userDetails->experience)) {
			$step = 2;
		}

		if ($userDetails->identity_proof_name !== "no_image.png" && $userDetails->medical_registration_proof_name !== "no_image.png" && $userDetails->doctor_digital_sign_name !== "no_image.png" && $userDetails->doctor_digital_stamp_name !== "no_image.png") {
			$step = 3;
		}
	}
	return $step;
}
 */

function unique_array($my_array, $key)
{
	$result = array();
	$i = 0;
	$key_array = array();

	foreach ($my_array as $val) {
		if (!in_array($val[$key], $key_array)) {
			$key_array[$i] = $val[$key];
			$result[$i] = $val;
		}
		$i++;
	}
	return $result;
}

function weekDayNumber($dayname)
{
	switch ($dayname) {
		case 'Monday':
			return 0;
			break;
		case 'Tuesday':
			return 1;
			break;
		case 'Wednesday':
			return 2;
			break;
		case 'Thursday':
			return 3;
			break;
		case 'Friday':
			return 4;
			break;
		case 'Saturday':
			return 5;
			break;
		case 'Sunday':
			return 6;
			break;

		default:
			return 0;
			break;
	}
}

//password generator
function passwordGenerate($chars)
{
	$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
	return substr(str_shuffle($data), 0, $chars);
}

function timeSort($times)
{
	usort($times, function ($a, $b) {
		return (int) (strtotime($a['start_time']) <=> strtotime($b['start_time']));
	});
	return $times;
}

function array_keys_multi(array $array)
{
	$keys = array();

	foreach ($array as $key => $value) {
		$keys[] = trim($key);

		if (is_array($value)) {
			$keys = array_merge($keys, array_keys_multi($value));
		}
	}

	return $keys;
}
/*
function getOrderID()
{
	$number = Payment::where('order_no', '!=', 0)->latest('order_no')->first();
	$order_no = (isset($number->order_no) && $number->order_no > 0) ? ($number->order_no + 1) : 1;
	$data['order_no'] = $order_no;
	$year = Carbon::now()->format('y');
	$month = Carbon::now()->format('m');

	if ($month > 3) {
		$prefix = $year . '' . ($year + 1);
	} else {
		$prefix = ($year - 1) . '' . $year;
	}

	$data['order_id'] = 'NC' . $prefix . '-' . $order_no;
	return $data;
} */







/* function get_lat_long($address){

	$address = str_replace(" ", "+", $address);
	//echo "https://maps.google.com/maps/api/geocode/json?key=".env('GOOGLE_MAP_API_KEY')."&address=$address&sensor=false&region=$region";
	$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyAAVvLhkgxYsKYuXVFeQph4ZCx81iX2wLI&address=$address&sensor=false");
	$json = json_decode($json);
	$data = array();
	$data['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	$data['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	return $data;
} */

function get_city($latlong)
{

	/*echo env('GOOGLE_MAP_API_KEY');
	   echo "https://maps.google.com/maps/api/geocode/json?key=".env('GOOGLE_MAP_API_KEY')."&latlng=".$latlong."&sensor=false";
	   exit;*/
	/* $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyAAVvLhkgxYsKYuXVFeQph4ZCx81iX2wLI&latlng=".$latlong."&sensor=false");
	   $json = json_decode($json);
	   $data = array();
		 $data['city'] = $json->{'results'}[0]->{'address_components'}[2]->{'long_name'};
		 $latlongArr = explode(',', $latlong);
		 $data['lat'] = $latlongArr[0];
		 $data['long'] = $latlongArr[1];
	   return $data; */
	//http://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&sensor=true&key=YOUR_KEY
}
function p($data, $i = 1)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	if ($i == 1) {
		die;
	}
}
