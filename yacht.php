<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // load record from 'yachts'
  list($yachtsRecords, $yachtsMetaData) = getRecords(array(
    'tableName'   => 'yachts',
    'where'       => whereRecordNumberInUrl(0),
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $yachtsRecord = @$yachtsRecords[0]; // get first record
  if (!$yachtsRecord) { dieWith404("Record not found!"); } // show error message if no record found

  // load records from 'reviews'
  $yachtID = $yachtsRecord['num'];
  list($reviewsRecords, $reviewsMetaData) = getRecords(array(
    'tableName'   => 'reviews',
    'where'     => "yacht = '". mysql_escape($yachtID) ."'", 
    'loadUploads' => false,
    'allowSearch' => false,
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

  include("includes/headers.php");
  
?><!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlencode($yachtsRecord['yacht_name']) ?>, <?php echo $yachtsRecord['charter_type:label'] ?> <?php echo $yachtsRecord['yacht_type:label'] ?> Charter - <?php echo htmlencode($settingsRecord['company_name']) ?></title>
  <meta name="description" content="<?php echo htmlencode($yachtsRecord['meta_description']) ?>">
  <link rel="canonical" href="<?php echo $settingsRecord['website_address'] ?><?php echo $yachtsRecord['_link'] ?>">
<?php include("includes/head.php"); ?>
  
  <?php 
    if ($yachtsRecord['banner_image']) {
      foreach ($yachtsRecord['banner_image'] as $index => $upload) {
        $hero_xl = ($upload['thumbUrlPath']);
        $hero_lg = ($upload['thumbUrlPath2']);
        $hero_md = ($upload['thumbUrlPath3']);
        break;
      }
      foreach ($yachtsRecord['list_image'] as $index => $upload) {
        $hero_sm = ($upload['thumbUrlPath']);
        break;
      }
    } elseif ($settingsRecord['default_banner']) {
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
    @media screen and (min-width: 640px) { /* was 480 */
      .hero { background-image: url(<?php echo htmlencode($hero_md) ?>); }
    }
    @media screen and (min-width: 960px) { /* was 768 */
      .hero { background-image: url(<?php echo htmlencode($hero_lg) ?>); }
    }
    @media screen and (min-width: 1400px) { /* was 1200 */
      .hero { background-image: url(<?php echo htmlencode($hero_xl) ?>); }
    }
    .section-feature-guide  {
      background-image: url(<?php foreach ($settingsRecord['promo_background_image'] as $index => $upload): ?><?php echo htmlencode($upload['thumbUrlPath']) ?><?php break ?><?php endforeach ?>);
    }
  </style>
</head>

<body>

<?php include("includes/header.php"); ?>

<section class="hero<?php if (!$yachtsRecord['banner_image']): ?> no-hero<?php endif ?>">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <div class="content">
          <div class="hero-title-wrap">
            <h1 class="hero-title"><?php echo htmlencode($yachtsRecord['yacht_name']) ?></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="large-12 cell">

      <section class="section-page-tabs page-tabs padding-bottom-1">

        <ul class="tabs" data-active-collapse="true" data-allow-all-closed="true"data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-tabs" id="page-tabs">
          <li class="tabs-title is-active"><a href="#panelAbout" aria-selected="true">Overview</a></li>
          <li class="tabs-title"><a href="#panelSpecifications">Specifications</a></li>
          <?php if ($yachtsRecord['show_skippered'] == 1): ?><li class="tabs-title"><a href="#panelSkipperedOptions">Skippered Options</a></li><?php endif ?>
          <?php if ($yachtsRecord['show_crewed'] == 1): ?><li class="tabs-title"><a href="#paneCrewOptions">Crew Options</a></li><?php endif ?>
          <?php if ($reviewsRecords): ?><li class="tabs-title"><a href="#paneReviews">Reviews</a></li><?php endif ?>
        </ul>

        <nav aria-label="You are here:" role="navigation" class="margin-top-1">
          <ul class="breadcrumbs">
            <li><a href="/">Home</a></li>
            <li><a href="/yachts.php">Yachts</a></li>
            <li><?php echo htmlencode($yachtsRecord['yacht_name']) ?></li>
          </ul>
        </nav>

        <div class="tabs-content" data-tabs-content="page-tabs">
          
          <div class="tabs-panel is-active" id="panelAbout">

            <h2 class="tabs-panel-title"><?php echo htmlencode($yachtsRecord['yacht_name']) ?> - <?php echo $yachtsRecord['charter_type:label'] ?> <?php echo $yachtsRecord['yacht_type:label'] ?></h2>

            <p class="text-lead"><?php echo htmlencode($yachtsRecord['intro']) ?></p>

            <?php if ($yachtsRecord['banner_image']): // Show smaller banner instead with specs to right ?>
            <?php foreach ($yachtsRecord['banner_image'] as $index => $upload): ?>
              <?php if ($upload['width'] == "559"): ?>
              <div class="grid-container">
                <div class="grid-x grid-margin-x">
                  <div class="cell small-12 large-8"><img src="<?php echo htmlencode($upload['urlPath']) ?>" width="<?php echo $upload['width'] ?>" height="<?php echo $upload['height'] ?>" alt="" /></div>
                  <div class="cell small-12 large-4 content feature-box">
                      <dl class="overview-list">
                        <dt>Length:</dt>
                        <dd><?php echo htmlencode($yachtsRecord['yacht_length']) ?>' (<?php echo round($yachtsRecord['yacht_length'] * 0.3048, 1) ?>m)</dd>
                        <dt>Charter Type:</dt>
                        <dd><?php echo $yachtsRecord['charter_type:label'] ?></dd>
                        <dt>Guest Max:</dt>
                        <dd><?php echo htmlencode($yachtsRecord['guests_max']) ?></dd>
                        <dt>Cabins:</dt>
                        <dd><?php echo htmlencode($yachtsRecord['cabins']) ?></dd>
                      </dl>
                  </div>
                </div>
              </div>
            <?php endif ?>
            <?php endforeach ?>
            <?php endif ?>

            <div class="content feature-box">
              <dl class="overview-list">
                <dt>Length:</dt>
                <dd><?php echo htmlencode($yachtsRecord['yacht_length']) ?>' (<?php echo round($yachtsRecord['yacht_length'] * 0.3048, 1) ?>m)</dd>
                <dt>Charter Type:</dt>
                <dd><?php echo $yachtsRecord['charter_type:label'] ?></dd>
                <dt>Guest Max:</dt>
                <dd><?php echo htmlencode($yachtsRecord['guests_max']) ?></dd>
                <dt>Cabins:</dt>
                <dd><?php echo htmlencode($yachtsRecord['cabins']) ?></dd>
              </dl>
            </div>

            <?php if ($yachtsRecord['gallery_images']): ?> 
            <div class="sc-carousel carousel" data-flickity='{"fullscreen": true, "lazyLoad": 1, "pageDots": true, "cellAlign": "left", "wrapAround": true, "adaptiveHeight": true, "setGallerySize": false}'>
              <?php foreach ($yachtsRecord['gallery_images'] as $index => $upload): ?>
              <div class="carousel-cell">
                <img 
                src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" data-flickity-lazyload="<?php echo htmlencode($upload['thumbUrlPath']) ?>"
                alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
              <?php endforeach ?>
            </div>
            <?php endif ?>

            <?php echo $yachtsRecord['description']; ?>

            <?php if ($yachtsRecord['rate_low_season']||$yachtsRecord['rate_high_season']): ?>
            <h2>Rates</h2>
            <?php if ($yachtsRecord['rate_notes']): ?><p><?php echo $yachtsRecord['rate_notes'] ?></p><?php endif ?>
            <ul>
            <?php if ($yachtsRecord['rate_low_season']): ?><li>Rate (Low Season): <?php if ($yachtsRecord['rate_currency']): ?><?php echo $yachtsRecord['rate_currency:label'] ?><?php endif ?><?php echo htmlencode($yachtsRecord['rate_low_season']) ?></li><?php endif ?>
            <?php if ($yachtsRecord['rate_high_season']): ?><li>Rate (High Season): <?php if ($yachtsRecord['rate_currency']): ?><?php echo $yachtsRecord['rate_currency:label'] ?><?php endif ?><?php echo htmlencode($yachtsRecord['rate_high_season']) ?></li><?php endif ?>
            </ul>
            <?php endif ?>


            <?php if ($yachtsRecord['media_embed']): ?>
            <div class="grid-container">
            <div class="grid-x grid-padding-x small-margin-collapse">
            <div class="large-6 cell">
            <?php endif ?>

            <?php if ($yachtsRecord['regions']||$yachtsRecord['destinations']): ?>
            <h3>Charter Locations</h3>
            <ul>

              <?php if ($yachtsRecord['regions']): ?>
                  <?php  // load records from 'regions'
                  $regionID = " " . $yachtsRecord['regions'] . " ";
                  list($region_listRecords, $region_listMetaData) = getRecords(array(
                  'tableName'   => 'region_list',
                  'loadUploads' => false,
                  'allowSearch' => false,
                  'where'       => "'". mysql_escape($regionID) ."' LIKE CONCAT('%\t', num ,'\t%') " . ' AND hidden ="0"', 
                  ));
                  ?>
                  <?php $countD=0; ?>
                  <li>Regions:
                      <?php foreach ($region_listRecords as $record): ?>
                        <?php echo ($countD==0)? "" : ", " ?>
                        <?php if ($record['region_link']): ?>
                          <a href="/<?php echo $record['region_link'] ?>/">
                          <?php echo htmlencode($record['region']) ?>
                          </a>
                        <?php else: ?>
                          <?php echo htmlencode($record['region']) ?>
                        <?php endif ?>
                        <?php $countD++;?>
                    <?php endforeach ?>
                  </li>
              <?php endif ?>

              <?php if ($yachtsRecord['destinations']): ?>
                  <?php  // load records from 'destinations'
                  $destID = " " . $yachtsRecord['destinations'] . " ";
                  list($destination_listRecords, $destination_listMetaData) = getRecords(array(
                  'tableName'   => 'destination_list',
                  'loadUploads' => false,
                  'allowSearch' => false,
                  'where'       => "'". mysql_escape($destID) ."' LIKE CONCAT('%\t', num ,'\t%') " . ' AND hidden ="0"', 
                  ));
                  ?>
                  <?php $countD=0; ?>
                  <li>Destinations:
                      <?php foreach ($destination_listRecords as $record): ?><?php echo ($countD==0)? "" : ", " ?><?php if ($record['destination_link']): ?><a href="/<?php echo $record['destination_link'] ?>/"><?php echo htmlencode($record['destination']) ?></a><?php else: ?><?php echo htmlencode($record['destination']) ?><?php endif ?><?php $countD++;?><?php endforeach ?>
                  </li>
              <?php endif ?>

            </ul>
            <?php endif ?>

            <?php if ($yachtsRecord['media_embed']): ?>
            </div>
            <div class="large-6 cell">
            <?php endif ?>

            <?php if ($yachtsRecord['media_embed']): ?>
              <?php if ($yachtsRecord['media_aspect_ratio'] == 1): ?> 
              <div class="responsive-embed">
                <iframe width="420" height="315" src="<?php echo htmlencode($yachtsRecord['media_embed']) ?>" frameborder="0" allowfullscreen></iframe>
              </div>
              <?php else: ?>
              <div class="responsive-embed widescreen">
                <iframe width="560" height="315" src="<?php echo htmlencode($yachtsRecord['media_embed']) ?>" frameborder="0" allowfullscreen></iframe>
              </div>
              <?php endif ?>
            <?php endif ?>

            <?php if ($yachtsRecord['media_embed']): ?>
            </div></div></div>
            <?php endif ?>

          </div>

          <div class="tabs-panel" id="panelSpecifications">

            <h2 class="tabs-panel-title">Specifications</h2>

            <ul class="spec-list no-bullet">
              <?php if ($yachtsRecord['guests_max']): ?><li><span>Guests (Max):</span> <?php echo htmlencode($yachtsRecord['guests_max']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['guests_recommended']): ?><li><span>Guests (Recommended):</span> <?php echo htmlencode($yachtsRecord['guests_recommended']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['cabins']): ?><li><span>Cabins:</span> <?php echo htmlencode($yachtsRecord['cabins']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['berths']): ?><li><span>Berths:</span> <?php echo htmlencode($yachtsRecord['berths']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['heads']): ?><li><span>Heads:</span> <?php echo htmlencode($yachtsRecord['heads']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['showers']): ?><li><span>Showers:</span> <?php echo htmlencode($yachtsRecord['showers']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['yacht_length']): ?><li><span>Length:</span> <?php echo htmlencode($yachtsRecord['yacht_length']) ?>' (<?php echo round($yachtsRecord['yacht_length'] * 0.3048, 1) ?>m)</li><?php endif ?>
              <?php if ($yachtsRecord['beam']): ?><li><span>Beam:</span> <?php echo htmlencode($yachtsRecord['beam']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['draft']): ?><li><span>Draft:</span> <?php echo htmlencode($yachtsRecord['draft']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['engine_s']): ?><li><span>Engine(s):</span> <?php echo htmlencode($yachtsRecord['engine_s']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['fuel_capacity']): ?><li><span>Fuel Capacity:</span> <?php echo htmlencode($yachtsRecord['fuel_capacity']) ?></li><?php endif ?>
              <?php if ($yachtsRecord['water_capacity']): ?><li><span>Water Capacity:</span> <?php echo htmlencode($yachtsRecord['water_capacity']) ?></li><?php endif ?>
            </ul>

            <?php if ($yachtsRecord['equipment']): ?><p class="margin-bottom-2"><strong>Equipment Includes:</strong> <?php echo htmlencode($yachtsRecord['equipment']) ?></p><?php endif ?>

            <h3 class="text-center">Yacht Layout</h3>

            <?php if ($yachtsRecord['spec_images']): ?>
            <?php foreach ($yachtsRecord['spec_images'] as $index => $upload): ?>
              <div class="text-center"><img src="<?php echo htmlencode($upload['thumbUrlPath']) ?>" alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
            <?php endforeach ?>

            <?php if ($yachtsRecord['charter_type'] == "1"): ?>
            <?php if ($settingsRecord['bareboat_layout_statement']): ?><p class="margin-1 text-center"><?php echo htmlencode($settingsRecord['bareboat_layout_statement']) ?></p><?php endif ?>
            <?php endif ?>

            <?php endif ?>



          </div>

          <?php if ($yachtsRecord['show_skippered'] == 1): ?>
          <div class="tabs-panel" id="panelSkipperedOptions">
            <h2 class="tabs-panel-title">Skippered Options</h2>
            <?php if ($yachtsRecord['custom_skippered_text']): ?>
              <?php echo $yachtsRecord['custom_skippered_text']; ?>
            <?php else: ?>
              <?php echo $settingsRecord['skippered_default']; ?>
            <?php endif ?>
          </div>
          <?php endif ?>

          <?php if ($yachtsRecord['show_crewed'] ==1): ?>
          <div class="tabs-panel" id="paneCrewOptions">
            <h2 class="tabs-panel-title">Crew Options</h2>
            <?php if ($yachtsRecord['custom_crewed_text']): ?>
              <?php echo $yachtsRecord['custom_crewed_text']; ?>
            <?php else: ?>
              <?php echo $settingsRecord['crewed_default']; ?>
            <?php endif ?>
          </div>
          <?php endif ?>

          <?php if ($reviewsRecords): ?>
          <div class="tabs-panel" id="paneReviews">
            <h2 class="tabs-panel-title text-center">Reviews</h2>
            <div class="grid-x grid-padding-y grid-margin-x">
              <?php foreach ($reviewsRecords as $record): ?>
              <blockquote class="large-6 cell">
                <?php if ($record['rating']): ?><div>Rating: <?php echo $record['rating'] ?> / 5</div><?php endif ?>
                <?php echo htmlencode($record['content']) ?>
                <cite><?php echo htmlencode($record['who']) ?>, <?php echo date("M jS, Y", strtotime($record['review_date'])) ?></cite>
              </blockquote>
              <?php endforeach ?>
            </div>
          </div>
          <?php endif ?>

        </div>
        
      </section>
    
      <section class="section-cta-inline padding-bottom-3">
        <div class="grid-x content feature-box">
          <div class="medium-9 cell cell-center">
            <span><?php echo htmlencode($settingsRecord['cta_single_line']) ?></span>
          </div>
          <div class="medium-3 cell cell-center cell-buttons">
            <a href="#" class="button secondary" data-open="exampleModal1"><i class="sc-icon-mail" aria-hidden="true"></i> Get in Touch</a>
          </div>
        </div>
      </section>

    </div><!-- large-12 cell -->
  </div><!-- grid-x grid-padding-x -->
</div><!-- grid-container -->

<?php include("includes/footer-cta.php"); ?>
<?php include("includes/footer-promo.php"); ?>
<?php include("includes/footer.php"); ?>

</div><!-- END Off-canvas Content -->

<?php include("includes/form-modal.php"); ?>
<?php include("includes/footer-scripts.php"); ?>

</body>
</html>
