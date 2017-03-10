<?php
// Include the dependencies

$cas_path = "../vendor/phpCAS/CAS.php";
    SSO\SSO::setCASPath($cas_path);

// Authenticate the user
use SSO\SSO;
SSO::authenticate();
// At this point, the authentication has succeeded.
// This shows how to get the user details.
$user = SSO::getUser();
if ($user->role === 'mahasiswa')
	echo $user->username . ' ' . $user->name . ' ' . $user->npm . ' ' . $user->role . ' ' . $user->faculty . ' ' . $user->study_program . ' ' . $user->educational_program;
else if ($user->role === 'staff')
	echo $user->username . ' ' . $user->name . ' ' . $user->nip . ' ' . $user->role;