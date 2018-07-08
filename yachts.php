<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/dev.sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // load records from 'yachts'
  list($yachtsRecords, $yachtsMetaData) = getRecords(array(
    'tableName'   => 'yachts',
    'perPage'     => '20',
    'loadUploads' => true,
    'allowSearch' => true,
  ));

  // load record from 'settings'
  list($settingsRecords, $settingsMetaData) = getRecords(array(
    'tableName'   => 'settings',
    'where'       => '', // load first record
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $settingsRecord = @$settingsRecords[0]; // get first record

?><!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yacht Search - Sail Connections</title>
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
            <h1 class="hero-title">Charter Yachts (currently working on this)</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="search section-inverse section-bg-secondary-4">
  <form action="/yachts.php" method="get">
    <div class="grid-container">
      <div class="grid-x">
        <!-- <div class="cell medium-auto">
          <legend class="text-right middle">Yacht Search</legend>
        </div> -->
        <div class="cell medium-auto">
          <label for="searchDestination">Destination</label>
          <?php
            list($search_destination_listRecords, $destination_listMetaData) = getRecords(array(
              'tableName'   => 'destination_list',
              'loadUploads' => false,
              'allowSearch' => false,
            ));
          ?>
          <select id="searchDestination" name="destinations">
            <option selected disabled>Destination</option>
            <?php foreach ($search_destination_listRecords as $record): ?>
            <option value="<?php echo $record['num'] ?>" <?php selectedIf( $record['num'],  @$_REQUEST['destinations']) ?> >- <?php echo htmlspecialchars($record['destination']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="cell medium-auto">
          <label for="searchYachtType">Yacht Type</label>
          <?php
            list($search_yacht_type_listRecords, $yacht_typeMetaData) = getRecords(array(
            'tableName'   => 'yacht_type_list',
            'loadUploads' => false,
            'allowSearch' => false,
            ));
          ?>
          <select id="searchYachtType" name="yacht_type">
            <option selected disabled>Yacht Type</option>
            <?php foreach ($search_yacht_type_listRecords as $record): ?>
            <option value="<?php echo $record['num'] ?>" <?php selectedIf( $record['num'],  @$_REQUEST['yacht_type']) ?> >- <?php echo htmlspecialchars($record['yacht_type']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="cell medium-auto">
          <label for="searchCharterType">Charter Type</label>
          <?php
            list($search_charter_type_listRecords, $yacht_typeMetaData) = getRecords(array(
            'tableName'   => 'charter_type_list',
            'loadUploads' => false,
            'allowSearch' => false,
            ));
          ?>
          <select id="searchCharterType" name="charter_type">
            <option selected disabled>Charter Type</option>
            <?php foreach ($search_charter_type_listRecords as $record): ?>
            <option value="<?php echo $record['num'] ?>" <?php selectedIf( $record['num'],  @$_REQUEST['charter_type']) ?> >- <?php echo htmlspecialchars($record['charter_type']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="cell medium-4 large-3">
          <label for="searchKeyword">Keyword</label>
          <div class="input-group">
            <input class="input-group-field" type="text" id="searchKeyword" placeholder="Keyword...">
            <div class="input-group-button">
              <input type="submit" class="button secondary" value="Search">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="large-12 cell">

      <section class="search-results">

        <div class="search-filter">
          <div class="search-filter-header h5">
            [Yacht Type] for Charter in [Destination]
          </div>
          <div class="search-filter-nav">
            <ul class="menu simple">
              <li class="menu-text fw-normal">Sort by:</li>
              <li class="is-active"><a href="#">Default</a></li>
              <li><a href="#">Rate</a></li>
              <li><a href="#">Length</a></li>
              <li><a href="#">Guests</a></li>
            </ul>
          </div>
          <div class="search-results-count">
            Page <?php echo $yachtsMetaData['page'] ?> of <?php echo $yachtsMetaData['totalPages'] ?>
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
