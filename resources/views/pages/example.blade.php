@extends('main')

@section('title', '| Example')

@section('body')
		<?php
			$cas_path = "../vendor/phpCAS/CAS.php";
			SSO\SSO::setCASPath($cas_path);
			SSO\SSO::authenticate();

			$user = SSO\SSO::getUser();

			echo '<ul>';
			foreach ($user as $value) {
				echo '<li>' . $value . '</li>';
			}
			echo '</ul>';
		?>
@endsection
