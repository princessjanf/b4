@extends('main')

@section('title', '| Example')

@section('nav.beranda')
	class="active"
@endsection

@section('nav.user')
	<?php
			echo '<ul>';
			echo $user->username;
			echo '</ul>';
		?>
@endsection

@section('body')
		<?php
			echo '<ul>';
			echo "alvin nih";
			foreach ($user as $value) {
				echo '<li>' . $value . '</li>';
			}
			echo '</ul>';
		?>
@endsection