<?php
session_start();
$page_title = "Gardener Dashboard";

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in as a gardener to view this page.");
}

$page_content = "
    <h1 class='text-3xl font-bold'>Welcome to the Gardener Dashboard!</h1>
    <p class='mt-4'>Manage your tasks and view your completed jobs here.</p>

    <div class='mt-6 flex flex-col gap-4'>
        <a href='hire_requests.php' class='btn btn-primary'>View Hire Requests</a>
        <a href='completed_requests.php' class='btn btn-success'>Completed Jobs</a>
        <a href='update_profile.php' class='btn btn-secondary'>Update Profile</a>
    </div>
";

include './components/layout.php';
?>