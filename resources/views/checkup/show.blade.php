@extends('main')
@section('title', 'Check-Up')
@section('stylesheets')

	{!! Html::style('css/parsley.css') !!}
	{!! Html::style('dist/datepicker.css') !!}

@endsection

@section('content')
<div class="container">
	<h1 class="title-page">{{$patients->patient_lname.', '.$patients->patient_fname}}</h1>
	<!-- Trigger the modal with a button -->
	<br>

	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add">Add</button>
	
	<div id="add" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Check-Up</h4>
	      </div>
	      <div class="modal-body">
	        {!! Form::open(['route' => 'checkup.store','data-parsley-validate' => '']) !!}

				<div class="row">
				  <div class="form-group col-xs-5 col-lg-6">

				    {{ Form::label('checkup_date', "Date") }}
				    {{ Form::date('checkup_date', null, ['class' => 'form-control', 'data-toggle'=> 'datepicker','required' => '', 'data-parsley-date','maxlength' => '10']) }}

				  </div>
			    </div>

			    <div class="row">
				  <div class="form-group col-xs-5 col-lg-3">

				    {{ Form::label('patient_weight', "Weight") }}
				    {{ Form::number('patient_weight', 0, ['class' => 'form-control', 'required' => '', 'maxlength' => '255','data-parsley-type' => 'number']) }}
				  </div>
				  <div class="form-group col-xs-5 col-lg-3">

				    {{ Form::label('patient_height', "Height") }}
				    {{ Form::number('patient_height', 0, ['class' => 'form-control', 'required' => '', 'maxlength' => '255','data-parsley-type' => 'number']) }}
				  </div>
			    </div>

			    <div class="row">
				  <div class="form-group col-xs-5 col-lg-6">
					<label for="">Doctor</label>
				    <select class="form-control" name="doctor_name">
	
					   	@foreach ($medicalpersonnels as $medicalpersonnel)
							<option value="{{ $medicalpersonnel->medicalpersonnel_name }}">{{ $medicalpersonnel->medicalpersonnel_name }}</option>
						@endforeach

					</select>
				    {{ Form::hidden('patient_id', $patients->PatientID) }}
					
				  </div>
			    </div>

			    <div class="row">
				  <div class="form-group col-xs-5 col-lg-6">

				    {{ Form::label('checkup_description', "Description") }}
				    {{ Form::text('checkup_description', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

				  </div>
			    </div>

			    <div class="row">
				  <div class="form-group col-xs-5 col-lg-6">

				    {{ Form::label('checkup_symptoms', "Symptoms") }}
				    {{ Form::text('checkup_symptoms', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

				  </div>
			    </div>

			    <div class="row">
				  <div class="form-group col-xs-5 col-lg-6">

				    {{ Form::label('checkup_prescription', "Prescription") }}
				    {{ Form::text('checkup_prescription', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}
				  </div>
			    </div>
			    
			    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
			{!! Form::close() !!}
			
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	
	  </div>
	</div>
      

<hr>
<div class="row">
    <div class="table-responsive">
        <table class="table table-hover">

	      <thead>
	        <tr>
	          <th>Check-Up Date</th>
	          <th>Doctor</th>
	          <th>Symptoms</th>
	          <th>Prescription</th>
	          <th>Description</th>
	          <th>Weight</th>
	          <th>Height</th>
	        </tr>
	      </thead>

	      <tbody id="checklist">

			@foreach($checklists as $checklist)

	          <tr>
	            <td><p>{{$checklist->checkup_date}}</p></td>
	            <td><p>{{$checklist->doctor_name}}</p></td>
	            <td><p>{{$checklist->checkup_symptoms}}</p></td>
	            <td><p>{{$checklist->checkup_prescription}}</p></td>
	            <td><p>{{$checklist->checkup_description}}</p></td>
	            <td><p>{{$checklist->patient_weight}}</p></td>
	            <td><p>{{$checklist->patient_height}}</p></td>
	            {{-- <td><button type="button" class="btn btn-success" id="edit" data-id="{{$checklist->id}}" data-toggle="modal" data-target="#edit_{{$checklist->id}}">Edit</button></td>
 --}}
	           </tr>


	           <!-- Edit Modal -->
				<div id="edit_{{$checklist->CheckupID}}" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Edit</h4>
				      </div>
				      <div class="modal-body">
				        {!! Form::model($checklist, ['route' => ['checkup.update', $checklist->CheckupID ], 'method'=> 'PUT']) !!}

				        	<div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('checkup_date', "Checkup-date") }}
							    {{ Form::text('checkup_date', $checklist->checkup_date, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

							  </div>
						    </div>

						    <div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('doctor', "Doctor") }}
							    {{ Form::text('doctor', $checklist->doctor_name, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

							  </div>
						    </div>

							<div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('checkup_symptoms', "Symptoms") }}
							    {{ Form::text('checkup_symptoms', $checklist->checkup_symptoms, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

							  </div>
						    </div>

						    <div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('checkup_prescription', "Prescription") }}
							    {{ Form::text('checkup_prescription', $checklist->checkup_prescription, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

							  </div>
						    </div>

						    <div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('checkup_description', "Description") }}
							    {{ Form::text('checkup_description', $checklist->checkup_description, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

							  </div>
						    </div>

						    <div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('patient_weight', "patient_weight") }}
							    {{ Form::number('patient_weight', $checklist->patient_weight, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}
							    {{ Form::hidden('patient_id', $checklist->patient_id) }}

							  </div>
						    </div>

						    <div class="row">
							  <div class="form-group col-xs-5 col-lg-7">

							    {{ Form::label('patient_height', "patient_height") }}
							    {{ Form::text('patient_height', $checklist->patient_height, ['class' => 'form-control', 'required' => '', 'maxlength' => '255']) }}

							  </div>
						    </div>

							{{ Form::submit('Save Changes', ['class' => 'btn btn-success']) }}

						{!! Form::close() !!}
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>
				<!-- END Modal -->

			@endforeach

	      </tbody>
	    </table>
	</div>
  </div>
</div>	
@endsection


@section('scripts')
	<script>
	    var token = '{{ Session::token() }}';
	    var url = '{{ route('posts.search') }}';
	    var add = '{{ route('posts.store') }}'
	    var index = "{{route('posts.index')}}";
	    var csrf = '{{ csrf_field() }}';
	</script>
	{!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('dist/datepicker.js') !!}
    {!! Html::script('js/checkup.js') !!}
    


	

@endsection
