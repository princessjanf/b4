@extends('main')

@section('title', '| Example')

@section('nav.beranda')
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