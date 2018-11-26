<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // load record from 'settings'
  list($settingsRecords, $settingsMetaData) = getRecords(array(
    'tableName'   => 'settings',
    'where'       => '', // load first record
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $settingsRecord = @$settingsRecords[0]; // get first record

  include("includes/headers.php");
  
?><!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found - <?php echo htmlencode($settingsRecord['company_name']) ?></title>
<?php include("includes/head.php"); ?>
  
</head>

<body>

<?php include("includes/header.php"); ?>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="large-12 cell padding-bottom-3">

      <section class="padding-top-3 padding-bottom-3 text-center">
        <h1>404 Page Not Found</h1>
        <p>Sorry but that page is no longer available. The technical error is 404 file not found.</p>
        
      </section>

    </div><!-- large-12 cell -->
  </div><!-- grid-x grid-padding-x -->
</div><!-- grid-container -->

<?php include("includes/footer.php"); ?>

</div><!-- END Off-canvas Content -->

<?php include("includes/form-modal.php"); ?>
<?php include("includes/footer-scripts.php"); ?>

</body>
</html>
