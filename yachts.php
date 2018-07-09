<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/dev.sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // determine sort order (defined in the URL)
  $customOrderBy = getCustomOrderBy(@$_REQUEST['sort']);

  // load records from 'yachts'
  list($yachtsRecords, $yachtsMetaData) = getRecords(array(
    'tableName'   => 'yachts',
    'perPage'     => '20',
    'loadUploads' => true,
    'allowSearch' => true,
    //'useSeoUrls'    => true,
    'orderBy'     => $customOrderBy,
  ));

  if(!@$_REQUEST['destinations']){
       $_REQUEST['destinations']=-1;
    }
   if(!@$_REQUEST['yacht_type']){
       $_REQUEST['yacht_type']=-1;
    }
   if(!@$_REQUEST['charter_type']){
       $_REQUEST['charter_type']=-1;
    }

  list($destinationsRecords, $destinationsMetaData) = getRecords(array(
    'tableName'   => 'destination_list',
    'where'       => "num=".intval(mysql_escape(@$_REQUEST['destinations'])),
    'limit'       => '1',
    'allowSearch' => false,
  ));
  $destinationsRecord = @$destinationsRecords[0]; // get first record
  
  list($yacht_typeRecords, $yacht_typeMetaData) = getRecords(array(
    'tableName'   => 'yacht_type_list',
    'where'       => "num ='".mysql_escape(@$_REQUEST['yacht_type'])."'",
    'limit'       => '1',
    'allowSearch' => false,
  ));
  $yacht_typeRecord = @$yacht_typeRecords[0]; // get first record

  list($charter_typeRecords, $charter_typeMetaData) = getRecords(array(
    'tableName'   => 'charter_type_list',
    'where'       => "num ='".mysql_escape(@$_REQUEST['charter_type'])."'",
    'limit'       => '1',
    'allowSearch' => false,
  ));
  $charter_typeRecord = @$charter_typeRecords[0]; // get first record

  // load record from 'settings'
  list($settingsRecords, $settingsMetaData) = getRecords(array(
    'tableName'   => 'settings',
    'where'       => '', // load first record
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $settingsRecord = @$settingsRecords[0]; // get first record

  $resultsText="";

  if ($destinationsRecord && $yacht_typeRecord && $charter_typeRecord) {
    $resultsText.=$charter_typeRecord['charter_type'] . " " . $yacht_typeRecord['yacht_type'] . " for charter in " . $destinationsRecord['destination'];
  }
  elseif ($destinationsRecord && $yacht_typeRecord) {
    $resultsText.=$yacht_typeRecord['yacht_type'] . " for charter in " . $destinationsRecord['destination'];
  }
  elseif ($destinationsRecord && $charter_typeRecord) {
    $resultsText.=$charter_typeRecord['charter_type'] . " charters in " . $destinationsRecord['destination'];
  }
  elseif ($yacht_typeRecord && $charter_typeRecord) {
    $resultsText.=$charter_typeRecord['charter_type'] . " " . $yacht_typeRecord['yacht_type'] . " for charter";
  }
  elseif ($destinationsRecord) {
    $resultsText.="Yachts for charter in " . $destinationsRecord['destination'];
  }
  elseif ($yacht_typeRecord) {
    $resultsText.=$yacht_typeRecord['yacht_type'] . " for charter";
  }
  elseif ($charter_typeRecord) {
    $resultsText.=$charter_typeRecord['charter_type'] . " yachts for charter";
  }
  elseif(@$_REQUEST['yacht_name_query,meta_description_query,intro_query,description_query']){
   $resultsText.="Search results for: " . $_REQUEST['yacht_name_query,meta_description_query,intro_query,description_query'];
  }

 ####
 // this function will determine what the URL is for each of the sorting links on the page
 // first click will give the order ASC
 // second click will give the order DESC
 // $sortingField options: rate, length, guests
 // usage: getSortingURL("rate");
 function getSortingURL($sortingField) {
      
      // sorting for "rate"
      if ($sortingField == "rate") {
            // first click -> set order to ASC
            if ( @$_REQUEST['sort'] == "rateASC" )                   { return array('param' => "sort=rateDESC", 'class' => "is-active sortdesc"); }
            // second click -> set order to DESC
            if ( @$_REQUEST['sort'] == "rateDESC" )                  { return array('param' => "sort=rateASC", 'class' => "is-active sortasc"); }

            if ( !@$_REQUEST['sort'] || @$_REQUEST['sort'] )         { return array('param' => "sort=rateASC", 'class' => ""); }
      }
      
      // sorting for "length"
      if ($sortingField == "length") {
            // first click -> set order to ASC
            if ( @$_REQUEST['sort'] == "lengthASC" )                 { return array('param' => "sort=lengthDESC", 'class' => "is-active sortdesc"); }
            // second click -> set order to DESC
            if ( @$_REQUEST['sort'] == "lengthDESC" )                { return array('param' => "sort=lengthASC", 'class' => "is-active sortasc"); }

            if ( !@$_REQUEST['sort'] || @$_REQUEST['sort'] )         { return array('param' => "sort=lengthASC", 'class' => ""); }
      }
      
      // sorting for "guests"
      if ($sortingField == "guests") {
            // first click -> set order to ASC
            if ( @$_REQUEST['sort'] == "guestsASC" )                 { return array('param' => "sort=guestsDESC", 'class' => "is-active sortdesc"); }
            // second click -> set order to DESC
            if ( @$_REQUEST['sort'] == "guestsDESC" )                { return array('param' => "sort=guestsASC", 'class' => "is-active sortasc"); }

            if ( !@$_REQUEST['sort'] || @$_REQUEST['sort'] )         { return array('param' => "sort=guestsASC", 'class' => ""); }
      }
      
      return "?";
 }

  function getCustomOrderBy($sort) {
      
      if (!@$sort)  { return ""; }
      
      switch ($sort) {
            case "rateASC":
                return "CAST(rate_high_season AS UNSIGNED) ASC";   
                break;
            case "rateDESC":
                return "CAST(rate_high_season AS UNSIGNED) DESC";
                break;
            case "lengthASC":
                return "yacht_length ASC";
                break;
            case "lengthDESC":
                return "yacht_length DESC";
                break;
            case "guestsASC":
                return "guests_max ASC";
                break;
            case "guestsDESC":
                return "guests_max DESC";
                break;
      }
      
      return "";
 }

?><!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php if ($resultsText): ?><?php echo $resultsText;?><?php else: ?>List of <?php echo $yachtsMetaData['totalRecords']; ?> Charter Yachts (Page <?php echo $yachtsMetaData['page'] ?>)<?php endif ?> - <?php echo $settingsRecord['company_name'] ?></title>
  <meta name="description" content="<?php echo $resultsText;?>">
<?php
  $canonical="";
  if ($destinationsRecord && $yacht_typeRecord && $charter_typeRecord) {
    $canonical.="?destinations=" . $destinationsRecord['num'] . "&amp;yacht_type=" . $yacht_typeRecord['num'] . "&amp;charter_type=" . $charter_typeRecord['num'];
  }
  elseif ($destinationsRecord && $yacht_typeRecord) {
    $canonical.="?destinations=" . $destinationsRecord['num'] . "&amp;yacht_type=". $yacht_typeRecord['num'];
  }
  elseif ($destinationsRecord && $charter_typeRecord) {
    $canonical.="?destinations=" . $destinationsRecord['num'] . "&amp;charter_type=" . $charter_typeRecord['num'];
  }
  elseif ($yacht_typeRecord && $charter_typeRecord) {
    $canonical.="?yacht_type=" . $yacht_typeRecord['num'] . "&amp;charter_type=" . $charter_typeRecord['num'];
  }
  elseif ($destinationsRecord) {
    $canonical.="?destinations=" . $destinationsRecord['num'];
  }
  elseif ($yacht_typeRecord) {
    $canonical.="?yacht_type=" . $yacht_typeRecord['num'];
  }
  elseif ($charter_typeRecord) {
    $canonical.="?charter_type=" . $charter_typeRecord['num'];
  }
  else {
   $canonical.="yachts.php";
  }
?>
<link rel="canonical" href="<?php echo $settingsRecord['website_address'] ?>/<?php echo $canonical ?>">
<?php if ($yachtsMetaData['prevPage']): ?>
  <link rel="prev" href="<?php echo $yachtsMetaData['prevPageLink'] ?>">
  <?php endif ?>
  <?php if ($yachtsMetaData['nextPage']): ?>
  <link rel="next" href="<?php echo $yachtsMetaData['nextPageLink'] ?>">
<?php endif ?>

<?php include("includes/head.php"); ?>
  
  <?php 
    if ($settingsRecord['default_banner']) {
      foreach ($settingsRecord['default_banner'] as $index => $upload) {
        $hero_xl = ($upload['thumbUrlPath']);
        $hero_lg = ($upload['thumbUrlPath2']);
        $hero_md = ($upload['thumbUrlPath3']);
        $hero_sm = ($upload['thumbUrlPath4']);
        break;
      }
    } else {
        $hero_xl = "/img/default-banner.jpg";
        $hero_lg = "/img/default-banner.jpg";
        $hero_md = "/img/default-banner.jpg";
        $hero_sm = "/img/default-banner.jpg";
    }
  ?>

  <!-- Hero images -->
  <style>
    .hero {
      background-image: url(<?php echo htmlencode($hero_sm) ?>);
    }
    @media screen and (min-width: 480px) {
      .hero { background-image: url(<?php echo htmlencode($hero_md) ?>); }
    }
    @media screen and (min-width: 768px) {
      .hero { background-image: url(<?php echo htmlencode($hero_lg) ?>); }
    }
    @media screen and (min-width: 1200px) {
      .hero { background-image: url(<?php echo htmlencode($hero_xl) ?>); }
    }
    .section-feature-guide  {
      background-image: url(<?php foreach ($settingsRecord['promo_background_image'] as $index => $upload): ?><?php echo htmlencode($upload['thumbUrlPath']) ?><?php break ?><?php endforeach ?>);
    }
  </style>

</head>

<body>

<?php include("includes/header.php"); ?>

<section class="hero hero-secondary">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <div class="content">
          <div class="hero-title-wrap">
            <h1 class="hero-title"><?php if ($resultsText): ?><?php echo $resultsText;?><?php else: ?>Yachts for Charter<?php endif ?></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("includes/search.php"); ?>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="large-12 cell">

      <section class="search-results">

        <div class="search-filter">
          <div class="search-filter-header h5">
            <?php if ($resultsText): ?><p><?php echo $resultsText;?></p>
            <?php else: ?>
            <p>Use the search options above &uarr; to filter results and the sort options below &darr; to sort the list of yachts.</p>
            <?php endif ?>
          </div>

          <div class="search-filter-nav">
            <ul class="menu simple">
              <li class="menu-text fw-normal">Sort by:</li>
              <li<?php if ( !@$_REQUEST['sort'] ): ?> class="is-active"<?php endif ?>><a href="?">Default</a></li>
              <li class="<?php echo getSortingURL('rate')['class']; ?>"><a href="?<?php echo preg_replace("/&sort=.*?(ASC|DESC)/", "", @$_SERVER['QUERY_STRING']); ?>&<?php echo getSortingURL('rate')['param']; ?>">Rate</a></li>
              <li class="<?php echo getSortingURL('length')['class']; ?>"><a href="?<?php echo preg_replace("/&sort=.*?(ASC|DESC)/", "", @$_SERVER['QUERY_STRING']); ?>&<?php echo getSortingURL('length')['param']; ?>">Length</a></li>
              <li class="hide-for-small-only <?php echo getSortingURL('guests')['class']; ?>">  <a href="?<?php echo preg_replace("/&sort=.*?(ASC|DESC)/", "", @$_SERVER['QUERY_STRING']); ?>&<?php echo getSortingURL('guests')['param']; ?>">Guests</a></li>
            </ul>
          </div>

          <div class="search-results-count">
            <?php echo $yachtsMetaData['totalRecords']; ?> results ( Page <?php echo $yachtsMetaData['page'] ?> of <?php echo $yachtsMetaData['totalPages'] ?> )
          </div>
        </div>

        <ul class="results-list card-list card-list-md-4 list-unstyled">

          <?php foreach ($yachtsRecords as $record): ?>
          <li class="result-item card">
            <a href="<?php echo $record['_link'] ?>">
              <div class="card-image">
                <?php if ($record['list_image']): ?>
                <?php foreach ($record['list_image'] as $index => $upload): ?>
                <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" alt="<?php echo htmlencode($record['yacht_name']) ?>">
                <?php endforeach ?>
                <?php else: ?>
                <img src="/img/no-image.png" alt="<?php echo htmlencode($record['yacht_name']) ?>">
                <?php endif ?>
              </div>
              <div class="card-section">
                <h3 class="card-title"><?php echo htmlencode($record['yacht_name']) ?></h3>
                <ul class="result-item-details list-unstyled">
                  <li>Length: <?php echo htmlencode($record['yacht_length']) ?>'</li>
                  <li>Guests: <?php echo htmlencode($record['guests_max']) ?></li>
                </ul>
              </div>
            </a>
          </li>
          <?php endforeach ?>

        </ul>

        <nav aria-label="Pagination">
          <ul class="search-pagination list-unstyled">
            
            <?php if ($yachtsMetaData['prevPage']): ?>
            <li>
              <a class="button button-icon-left" href="<?php echo $yachtsMetaData['prevPageLink'] ?>" aria-label="Previous page">
                <i class="sc-icon-arrow-left"></i> Previous</a>
            </li>
            <?php endif ?>

            <?php if ($yachtsMetaData['nextPage']): ?>
            <li>
              <a class="button button-icon-right" href="<?php echo $yachtsMetaData['nextPageLink'] ?>" aria-label="Next page">Next <i class="sc-icon-arrow-right"></i></a>
            </li>
            <?php endif ?>

          </ul>
        </nav>



      </section>

    </div><!-- large-12 cell -->
  </div><!-- grid-x grid-padding-x -->
</div><!-- grid-container -->

<?php include("includes/footer-cta.php"); ?>
<?php include("includes/footer-promo.php"); ?>
<?php include("includes/footer.php"); ?>

</body>
</html>
