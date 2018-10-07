<!--begin::Portlet-->
<div class="m-portlet">

<div class="m-portlet__head">
    <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
            
            <h3 class="m-portlet__head-text">
                Availability <small>可工作时间</small>
            </h3>
        </div>
    </div>
</div>

<div class="m-portlet__body">
    <table class="table">
			<thead>
			<tr><th>Day</th><th style="width:30%">From</th><th style="width:30%">To</th></tr>
			</thead>
			<tbody>
			<tr>
				<th>Monday</th>
				<td>
					{{$a->monFrom}}
				</td>
				<td>
					{{$a->monTo}}
				</td>
			</tr>
			<tr>
				<th>Tuesday</th>
				<td>
					{{$a->tueFrom}}
				</td>
				<td>
					{{$a->tueTo}}
				</td>
			</tr>
			<tr>
				<th>Wednesday</th>
				<td>
					{{$a->wedFrom}}
				</td>
				<td>
					{{$a->wedTo}}
				</td>
			</tr>
			<tr>
				<th>Thursday</th>
				<td>
					{{$a->thuFrom}}
				</td>
				<td>
					{{$a->thuTo}}
				</td>
			</tr>
			<tr>
				<th>Friday</th>
				<td>
					{{$a->friFrom}}
				</td>
				<td>
					{{$a->friTo}}
				</td>
			</tr>
			<tr>
				<th>Saturday</th>
				<td>
					{{$a->satFrom}}
				</td>
				<td>
					{{$a->satTo}}
				</td>
			</tr>
			<tr>
				<th>Sunday</th>
				<td>
					{{$a->sunFrom}}
				</td>
				<td>
					{{$a->sunTo}}
				</td>
			</tr>


				<tr>
					<th>Hour Limit per Week</th>
					<td>
						{{$a->hours}} Hours
					</td>
				</tr>

				<tr>
					<th>Holiday</th>
					<td>
						@if($a->holiday)
							<span class="m--font-success">Ok to work on holidays</span>
						@else
							<span class="m--font-success">Not available on holidays</span>
						@endif
					</td>
				</tr>
			
		</tbody>
		</table>
                          
    
</div>																
</div>
<!--end::Portlet-->

