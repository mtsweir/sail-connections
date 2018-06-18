<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/dev.sailconnections.com/','','../','../../','../../../');
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
  list($reviewsRecords, $reviewsMetaData) = getRecords(array(
    'tableName'   => 'reviews',
    'loadUploads' => true,
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

?><!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlencode($yachtsRecord['yacht_name']) ?> - <?php echo $yachtsRecord['yacht_type:label'] ?> - Sail Connections</title>
    <link rel="stylesheet" href="/temp/css/foundation.min.css">
    <link rel="stylesheet" href="temp/css/app.css?v=2">
  </head>
  <body>

    

  <article class="grid-container">
    <div class="grid-x">
      <div class="medium-12 cell">

        <h1><?php echo htmlencode($yachtsRecord['yacht_name']) ?></h1>

        <nav aria-label="You are here:" role="navigation">
          <ul class="breadcrumbs">
            <li><a href="/">Home</a></li>
            <li><a href="/yachts.php">Yachts</a></li>
            <li><?php echo htmlencode($yachtsRecord['yacht_name']) ?></li>
          </ul>
        </nav>

        <?php foreach ($yachtsRecord['banner_image'] as $index => $upload): ?>
          <p><img src="<?php echo htmlencode($upload['thumbUrlPath']) ?>" width="<?php echo $upload['thumbWidth'] ?>" height="<?php echo $upload['thumbHeight'] ?>" alt="" /></p>
          <?php break ?>
        <?php endforeach ?>
        
        <h2><?php echo htmlencode($yachtsRecord['yacht_name']) ?> <?php echo $yachtsRecord['charter_type:label'] ?> <?php echo $yachtsRecord['yacht_type:label'] ?> </h2>
        <p class="lead"><?php echo htmlencode($yachtsRecord['intro']) ?></p>
        <ul class="no-bullet">
          <li>Length: <?php echo htmlencode($yachtsRecord['yacht_length']) ?></li>
          <li>Charter Type: <?php echo $yachtsRecord['charter_type:label'] ?></li>
          <li>Guests (max): <?php echo htmlencode($yachtsRecord['guests_max']) ?></li>
          <li>Cabins: <?php echo htmlencode($yachtsRecord['cabins']) ?></li>
        </ul>

        <!--<?php if ($yachtsRecord['gallery_images']): ?> 
        <div class="orbit" role="region" aria-label="Gallery Images" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">
          <div class="orbit-wrapper">
            <div class="orbit-controls">
              <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
              <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
            </div>
            <ul class="orbit-container">
              <?php foreach ($yachtsRecord['gallery_images'] as $index => $upload): ?>
              <li class="is-active orbit-slide">
                <figure class="orbit-figure">
                  <img class="orbit-image" src="<?php echo htmlencode($upload['thumbUrlPath']) ?>" alt="<?php echo htmlencode($upload['info1']) ?>">
                  <figcaption class="orbit-caption"><?php echo htmlencode($upload['info1']) ?></figcaption>
                </figure>
              </li>
              <?php endforeach ?>
            </ul>
          </div>
          <nav class="orbit-bullets">
            <?php $count = 0;?>
            <?php $count2 = 1;?>
            <?php foreach ($yachtsRecord['gallery_images'] as $index => $upload): ?>
              <?php if ($count == 0): ?> 
                <button class="is-active" data-slide="<?php echo $count ?>"><span class="show-for-sr">Slide <?php echo $count2 ?></span><span class="show-for-sr">Current Slide</span></button>
              <?php else: ?>
                <button data-slide="<?php echo $count ?>"><span class="show-for-sr">Slide <?php echo $count2 ?></span></button>
              <?php endif ?>
              <?php $count++;?>
              <?php $count2++;?>
            <?php endforeach ?>
          </nav>
        </div>
        <?php endif ?>-->

        <?php if ($yachtsRecord['gallery_images']): ?> 
          <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-3">
            <?php foreach ($yachtsRecord['gallery_images'] as $index => $upload): ?>
                <div class="cell">
                  <a target="_blank" href="<?php echo htmlencode($upload['urlPath']) ?>" class="thumbnail">
                    <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" alt="<?php echo htmlencode($upload['info1']) ?>">
                  </a>
                </div>
            <?php endforeach ?>
          </div>
        <?php endif ?>

        <?php echo $yachtsRecord['description']; ?>

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

        <?php if ($yachtsRecord['rate_low_season']||$yachtsRecord['rate_high_season']): ?>
        <h2>Rates</h2>
        <?php if ($yachtsRecord['rate_notes']): ?><p><?php echo $yachtsRecord['rate_notes'] ?></p><?php endif ?>
        <ul>
        <?php if ($yachtsRecord['rate_low_season']): ?><li>Rate (Low Season): <?php if ($yachtsRecord['rate_currency']): ?><?php echo $yachtsRecord['rate_currency:label'] ?><?php endif ?><?php echo htmlencode($yachtsRecord['rate_low_season']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['rate_high_season']): ?><li>Rate (High Season): <?php if ($yachtsRecord['rate_currency']): ?><?php echo $yachtsRecord['rate_currency:label'] ?><?php endif ?><?php echo htmlencode($yachtsRecord['rate_high_season']) ?></li><?php endif ?>
        </ul>
        <?php endif ?>

        <h2>Specifications</h2>

        <ul class="two-col no-bullet">
        <?php if ($yachtsRecord['guests_max']): ?><li>Guests (Max): <?php echo htmlencode($yachtsRecord['guests_max']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['guests_recommended']): ?><li>Guests (Recommended): <?php echo htmlencode($yachtsRecord['guests_recommended']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['cabins']): ?><li>Cabins: <?php echo htmlencode($yachtsRecord['cabins']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['berths']): ?><li>Berths: <?php echo htmlencode($yachtsRecord['berths']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['heads']): ?><li>Heads: <?php echo htmlencode($yachtsRecord['heads']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['showers']): ?><li>Showers: <?php echo htmlencode($yachtsRecord['showers']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['yacht_length']): ?><li>Length: <?php echo htmlencode($yachtsRecord['yacht_length']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['beam']): ?><li>Beam: <?php echo htmlencode($yachtsRecord['beam']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['draft']): ?><li>Draft: <?php echo htmlencode($yachtsRecord['draft']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['engine_s']): ?><li>Engine(s): <?php echo htmlencode($yachtsRecord['engine_s']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['fuel_capacity']): ?><li>Fuel Capacity: <?php echo htmlencode($yachtsRecord['fuel_capacity']) ?></li><?php endif ?>
        <?php if ($yachtsRecord['water_capacity']): ?><li>Water Capacity: <?php echo htmlencode($yachtsRecord['water_capacity']) ?></li><?php endif ?>
        </ul>
        
        <?php if ($yachtsRecord['equipment']): ?>
        <p>Equipment Includes: <?php echo htmlencode($yachtsRecord['equipment']) ?></p>
        <?php endif ?>

        <?php if ($yachtsRecord['spec_images']): ?>
        <?php foreach ($yachtsRecord['spec_images'] as $index => $upload): ?>
          <img src="<?php echo htmlencode($upload['thumbUrlPath']) ?>" alt="<?php echo htmlencode($upload['info1']) ?>" />
        <?php endforeach ?>
        <?php endif ?>

        <?php if ($yachtsRecord['regions']||$yachtsRecord['destinations']): ?>
        <h2>Charter Locations</h2>
        <ul>
        <?php if ($yachtsRecord['regions']): ?><li>Regions: <?php echo join(', ', $yachtsRecord['regions:labels']); ?></li><?php endif ?>
        <?php if ($yachtsRecord['destinations']): ?><li>Destinations: <?php echo join(', ', $yachtsRecord['destinations:labels']); ?></li><?php endif ?>
        </ul>
        <?php endif ?>

        <hr>
        <p style="color: #C00;">DEV NOTE: Skippered and Crewed Options are off by default - see the checkboxes when editing yachts. There is default text in settings that you can override as needed. Let me know if you want this changed in any way to work better with your workflow. E.g. I can make it all on my default if that makes more sense.</p> 
        <hr>

        <?php if ($yachtsRecord['show_skippered']): ?>
          <h2>Skippered Options</h2>
          <?php if ($yachtsRecord['custom_skippered_text']): ?>
            <?php echo $yachtsRecord['custom_skippered_text']; ?>
          <?php else: ?>
            <?php echo $settingsRecord['skippered_default']; ?>
          <?php endif ?>
        <?php endif ?>

        <?php if ($yachtsRecord['show_crewed']): ?>
        <h2>Crewed Options</h2>
          <?php if ($yachtsRecord['custom_crewed_text']): ?>
            <?php echo $yachtsRecord['custom_crewed_text']; ?>
          <?php else: ?>
            <?php echo $settingsRecord['crewed_default']; ?>
          <?php endif ?>
        <?php endif ?>

        <?php if ($reviewsRecords): ?>
        <h2>Reviews</h2>
        <?php foreach ($reviewsRecords as $record): ?>
        <blockquote>
          <?php if ($record['rating']): ?><div>Rating: <?php echo $record['rating'] ?> / 5</div><?php endif ?>
          <?php echo htmlencode($record['content']) ?>
          <cite><?php echo htmlencode($record['who']) ?>, <?php echo date("M jS, Y", strtotime($record['review_date'])) ?></cite>
        </blockquote>
        <?php endforeach ?>
        <?php endif ?>

      </div>
    </div>
  </article>



    <script src="/js/vendor/jquery.js"></script>
    <script src="/js/vendor/what-input.js"></script>
    <script src="/js/vendor/foundation.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>
