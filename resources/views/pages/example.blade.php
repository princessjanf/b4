@extends('main')

@section('title', '| Example')

@section('nav.login')
	class="active"
@endsection

@section('body')
		<?php
			echo '<ul>';
			foreach ($user as $value) {
				echo '<li>' . $value . '</li>';
			}
			echo '</ul>';
		?>
@endsection
