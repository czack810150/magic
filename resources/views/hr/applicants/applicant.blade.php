<html>
<head>
<title>Applicant</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row mb-3">
    <div class="col-sm">
     <h4>Location: {{ $applicant->location->name }}</h4>
    </div>
    <div class="col-sm">
      <h4>Position: {{ $applicant->job->rank }}</h4>
    </div>
    <div class="col-sm">
     Employee Number:
    </div>
  </div>
  <hr>

<h4>Personal Information</h4>
  <div class="row mb-3">
  	<div class="col-sm">First Name: {{ $applicant->firstName }}</div>
  	<div class="col-sm">Last Name: {{ $applicant->lastName }}</div>
  	<div class="col-sm">中文名: {{ $applicant->cName}}</div>
  	<div class="col-sm">Gender: {{ $applicant->gender?'M':'F' }}</div>
  </div>

 <div class="row mb-3">
  	
  	<div class="col-sm">Phone: {{ $applicant->phone}}</div>
  	<div class="col-sm">email: {{ $applicant->email}}</div>
  	<div class="col-sm">Date of Birth: {{ $applicant->dob}}</div>
  	<div class="col-sm">Language:
		<ul>
			@if($applicant->chinese) <li>国语 Mandarin</li> @endif
			@if($applicant->english) <li>English</li> @endif
			@if($applicant->cantonese) <li>广东话 Cantonese</li> @endif
			@if($applicant->french) <li>French</li> @endif
		</ul></div>
  </div>

 <div class="row mb-3">
  	<div class="col-sm">Address: {{ $applicant->address}}</div>
  	<div class="col-sm">City: {{ $applicant->city}}</div>
  	<div class="col-sm">Province: {{ $applicant->province}}</div>
  	<div class="col-sm">Postal Code: {{ $applicant->postalCode}}</div>
  </div>

  <div class="row mb-3">
  	<div class="col-sm">Immigration Status: {{ $applicant->status}} {{ !is_null($applicant->expiry)?"Expiry Date: $applicant->expiry":'' }}</div>
  	<div class="col-sm">Hometown: {{ $applicant->hometown}}</div>
  	<div class="col-sm">Living in Canada Since: {{ $applicant->canada_entry}}</div>
  	
  </div>

<h4>Availability</h4>
<table class="table table-bordered table-sm">
<thead>
	<tr><th></th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>
</thead>
<tbody>
	<tr>
		<th scope="row">From</th>
		<td>{{ $applicant->availability->monFrom}}</td>
		<td>{{ $applicant->availability->tueFrom}}</td>
		<td>{{ $applicant->availability->wedFrom}}</td>
		<td>{{ $applicant->availability->thuFrom}}</td>
		<td>{{ $applicant->availability->friFrom}}</td>
		<td>{{ $applicant->availability->satFrom}}</td>
		<td>{{ $applicant->availability->sunFrom}}</td>
	</tr>
	<tr>
		<th scope="row">To</th>
		<td>{{ $applicant->availability->monTo}}</td>
		<td>{{ $applicant->availability->tueTo}}</td>
		<td>{{ $applicant->availability->wedTo}}</td>
		<td>{{ $applicant->availability->thuTo}}</td>
		<td>{{ $applicant->availability->friTo}}</td>
		<td>{{ $applicant->availability->satTo}}</td>
		<td>{{ $applicant->availability->sunTo}}</td>
	</tr>
</tbody>
</table>
<ul class="list-unstyled">
	<li>Work up to  {{ $applicant->availability->hours}} hours per week</li>
	<li>Work on holidays: {{ $applicant->availability->holiday?'Yes':'No'}}</li>

</ul>

<h4>Emergency Contact</h4>
 <div class="row mb-3">
  	<div class="col-sm">Name: {{ $applicant->emergency_person}}</div>
  	<div class="col-sm">Contact: {{ $applicant->emergency_phone }}</div>
  	<div class="col-sm">Relation: {{ $applicant->emergency_relation }}</div>
  	
  </div>
<h4>Education</h4>

 <div class="row mb-3">
  	<div class="col-sm">Level: {{ $applicant->education->education}}</div>
  	<div class="col-sm">Program / Major: {{ $applicant->education->major }}</div>
  	<div class="col-sm">School / Institution: {{ $applicant->education->school }}</div>
  	<div class="col-sm">Personal Interest: {{ $applicant->education->interest }}</div>
  	
  </div>

<h4>Most Recent Employment</h4>
 <div class="row mb-3">
  	<div class="col-sm">Business Name: {{ $applicant->pastwork->company}}</div>
  	<div class="col-sm">Address: {{ $applicant->pastwork->address}}</div>
  	<div class="col-sm">City: {{ $applicant->pastwork->city}}</div>
  	<div class="col-sm">Province: {{ $applicant->pastwork->province}}</div>
  	
  </div>
   <div class="row mb-3">
  	<div class="col-sm">From: {{ $applicant->pastwork->from}}</div>
  	<div class="col-sm">To: {{ $applicant->pastwork->to}}</div>
  	<div class="col-sm">Quit Reason:  {{ $applicant->pastwork->quitReason }}</div>

  	
  </div>



</div><!-- end of content  -->








	</body>
	</html>

