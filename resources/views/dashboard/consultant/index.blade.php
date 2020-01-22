@extends('layouts.blank')

@push('scripts')
	<!-- Date range picker -->
  <link href="{{ asset("css/daterangepicker.min.css") }}" rel="stylesheet">
@endpush

@section('title', 'Consultants')

@section('main_container')

<!-- page content -->
<div class="right_col" role="main">

	<div class="row">
		<div class="col-md-12 col-sm-12 ">
			@if($notification=Session::get('notification'))
		      <div class="alert alert-success">{{ $notification }}</div>
		  @elseif($notification_error=Session::get('notification_error'))
		      <div class="alert alert-danger">{{ $notification_error }}</div>
		  @endif
		</div>
	</div>

	<div class="page-title">
		<div class="title_left">
			<h3>Consultant <small>Dashboard</small></h3>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 ">
			<div class="x_panel">
				<div class="x_title">
					<h2>Selection Form</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br>

					<form id="consultant" method="get" class="form-horizontal form-label-left" novalidate="">
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="from-date">From <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="from-date" name="from-date" required="required" class="form-control">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="to-date">To <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="to-date" name="to-date" required="required" class="form-control">
							</div>
						</div>
						
						<div class="ln_solid"></div>

						@include('dashboard/consultant/includes/list')

						<div class="ln_solid"></div>

						<div class="item form-group">
							<div class="col-md-6 col-sm-6 offset-md-3">
								<button class="btn btn-primary" type="reset">Reset</button>
								<button type="submit" class="btn btn-success" formaction="{{route('consultant.relatory')}}">Relatory</button>
								<button type="submit" class="btn btn-success" formaction="{{route('consultant.graphic')}}">Graphic</button>
								<button type="submit" class="btn btn-success" formaction="{{route('consultant.cake')}}">Cake</button>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
@endsection

@push('scripts')
	<!-- Date range picker-->
	<script src="{{ asset("js/moment.min.js") }}"></script>
	<script src="{{ asset("js/daterangepicker.min.js") }}"></script>

	<script>
		$("#from-date, #to-date").daterangepicker({
			singleDatePicker: true,
			showDropdowns: true
		});
	</script>
@endpush