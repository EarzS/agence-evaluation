@extends('layouts.blank')

@section('title', 'Consultants')

@section('main_container')

<!-- page content -->
<div class="right_col" role="main">

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

					<form id="consultant" class="form-horizontal form-label-left" novalidate="">
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">From <span class="required">*</span>
							</label>
							<div class="col-md-3 col-sm-3 ">
								<input type="text" id="first-name" required="required" class="form-control ">
							</div>
							<div class="col-md-3 col-sm-3 ">
								<input type="text" id="last-name" name="last-name" required="required" class="form-control">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">To <span class="required">*</span>
							</label>
							<div class="col-md-3 col-sm-3 ">
								<input type="text" id="last-name" name="last-name" required="required" class="form-control">
							</div>
							<div class="col-md-3 col-sm-3 ">
								<input type="text" id="last-name" name="last-name" required="required" class="form-control">
							</div>
						</div>
						
						<div class="ln_solid"></div>

						@include('dashboard/consultant/includes/list')

						<div class="ln_solid"></div>

						<div class="item form-group">
							<div class="col-md-6 col-sm-6 offset-md-3">
								<button class="btn btn-primary" type="reset">Reset</button>
								<button type="submit" class="btn btn-success">Relatory</button>
								<button type="submit" class="btn btn-success">Graphic</button>
								<button type="submit" class="btn btn-success">Cake</button>
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