<?php

$surveyName = !empty($_REQUEST['name']) ? $_REQUEST['name'] : 'Survey';

// STIC-Custom 20240814 ART - Thank you message in surveys
// https://github.com/SinergiaTIC/SinergiaCRM/pull/339
$surveyThanks = translate('LBL_SURVEY_THANKS', 'Surveys');
// END STIC-Custom
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $surveyName; ?></title>

    <link href="themes/SuiteP/css/bootstrap.min.css" rel="stylesheet">
    <link href="custom/include/javascript/rating/rating.min.css" rel="stylesheet">
    <link href="custom/include/javascript/datetimepicker/jquery-ui-timepicker-addon.css" rel="stylesheet">
    <link href="include/javascript/jquery/themes/base/jquery.ui.all.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row well">
        <div class="col-md-offset-2 col-md-8">
            <h1><?= $surveyName; ?></h1>
            <!-- STIC-Custom 20240814 ART - Thank you message in surveys -->
            <!-- https://github.com/SinergiaTIC/SinergiaCRM/pull/339 -->
            <!-- <p>Thanks for completing this survey.</p> -->
            <p><?= $surveyThanks; ?></p>
            <!-- END STIC-Custom -->
        </div>
    </div>
</div>
<script src="include/javascript/jquery/jquery-min.js"></script>
<script src="include/javascript/jquery/jquery-ui-min.js"></script>
</body>
</html>
