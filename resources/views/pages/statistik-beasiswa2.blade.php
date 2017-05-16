@extends('master')

@section('title', 'Statistik')

@section('head')
	{!! Charts::assets() !!}
@endsection

@section('content')
	<div class="col-sm-12">
		{!! $chart->render() !!}
	</div>
`</br>`
				@for ($i = 0; $i < $countjenjang; $i++)
				<div class="col-sm-8">
				<?php		$var='chart'.$i;	?>
				{!! $$var->render() !!}
			</div>
			<div class="col-sm-4">
			</br>
					<table class="table table-stripped">
						<thead>
							<tr>
								<th> No </th>
								<th> Asd </th>
								<th>asas</th>
						</tr>
					</thead>
						<tbody>
							<tr>
								<td> asd </td>
								<td> asd </td>
								<td> asd </td>
							</tr>
						</tbody>
					</table>
			</div>
				@endfor

@endsection

@section('script')
@endsection
