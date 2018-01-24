<html>
<head>
<title>Applicant</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<h4>Location: {{ $applicant->location->name }} Position: {{ $applicant->job->rank }}</h4>
<h4>Personal Information</h4>
<ul class="list-unstyled">
	<li>中文名: {{ $applicant->cName}}</li>
	<li>First Name: {{ $applicant->firstName }}</li>
	<li>Last Name: {{ $applicant->lastName }}</li>
	<li>Gender: {{ $applicant->gender?'M':'F' }}</li>
	<li>Language:
		<ul>
			@if($applicant->chinese) <li>国语 Mandarin</li> @endif
			@if($applicant->english) <li>English</li> @endif
			@if($applicant->cantonese) <li>广东话 Cantonese</li> @endif
			@if($applicant->french) <li>French</li> @endif
		</ul>
	</li>
	<li>Address: {{ $applicant->address}}</li>
	<li>City: {{ $applicant->city}}</li>
	<li>Province: {{ $applicant->province}}</li>
	<li>Postal Code: {{ $applicant->postalCode}}</li>
	<li>EMail: {{ $applicant->email}}</li>
	<li>Phone: {{ $applicant->phone}}</li>
	<li>Date of Birth: {{ $applicant->dob}}</li>
	<li>Status: {{ $applicant->status}} {{ !is_null($applicant->expiry)?'Expiry Date: $applicant->expiry':'' }}</li>
	<li>Hometown: {{ $applicant->hometown}}</li>
	<li>Living in Canada Since: {{ $applicant->canada_entry}}</li>

</ul>
<h4>Emergency Contact</h4>
<ul class="list-unstyled">
	<li>Name: {{ $applicant->emergency_person}}</li>
	<li>Contact: {{ $applicant->emergency_phone }}</li>
	<li>Relation: {{ $applicant->emergency_relation }}</li>
</ul>
<h4>Education</h4>
<ul class="list-unstyled">
	<li>Level: {{ $applicant->education->education}}</li>
	<li>Program / Major: {{ $applicant->education->major?$applicant->major:'' }}</li>
	<li>School / Institution: {{ $applicant->education->school }}</li>
	<li>Personal Interest: {{ $applicant->education->interest }}</li>
</ul>
<h4>Most Recent Employment</h4>
<ul class="list-unstyled">
	<li>Business Name: {{ $applicant->pastwork->company}}</li>
	<li>Address: {{ $applicant->pastwork->address}}</li>
	<li>City: {{ $applicant->pastwork->city}}</li>
	<li>Province: {{ $applicant->pastwork->province}}</li>
	<li>From: {{ $applicant->pastwork->from}}</li>
	<li>To: {{ $applicant->pastwork->to}}</li>
	<li>Quit Reason:  {{ $applicant->pastwork->quitReason }}</li>
</ul>
	</body>
	</html>

