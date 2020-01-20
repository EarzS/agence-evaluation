<!-- Inicio de lista en tabla Aplica dual list box --> 
<table class="table table-striped projects">
	<thead>
		<tr>
			<th style="width: 1%">Select</th>
			<th style="width: 1%">Username</th>
			<th style="width: 20%">Name</th>
			<th>Created by</th>
		</tr>
	</thead>
	<tbody>
		@foreach($consultants as $index => $consultant)
		<tr>
			<td><!-- Username -->
				<input type="checkbox">
			</td>
			<td><!-- Username -->
				{{$consultant->co_usuario}}
			</td>
			<td><!-- Name -->
				{{$consultant->no_usuario}}
			</td>
			<td><!-- Created by -->
				{{$consultant->co_usuario_autorizacao}}
			</td>
		</tr>
		@endforeach			        
	</tbody>
</table>