<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/dev.sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // load record from 'pages'
  list($pagesRecords, $pagesMetaData) = getRecords(array(
    'tableName'   => 'pages',
    'where'       => whereRecordNumberInUrl(0),
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $pagesRecord = @$pagesRecords[0]; // get first record
  if (!$pagesRecord) { dieWith404("Record not found!"); } // show error message if no record found

  // load pages for breadcrumbs
  list($breadcrumbRecords, $selectedCategory) = getCategories(array(
  'tableName'           => 'pages', // REQUIRED
  'categoryFormat'      => 'breadcrumb', // showall, onelevel, twolevel, breadcrumb
  ));

  // If page is tagged with destination or region then get reviews
  if ($pagesRecord['destination'] || $pagesRecord['region']) { 
    if ($pagesRecord['destination']) { 
      $reviewID = $pagesRecord['destination']; 
      $review_type = "destination";

    } elseif ($pagesRecord['region']) { 
      $reviewID = $pagesRecord['region'];
      $review_type = "region";
    }
    // load records from 'reviews'
    list($reviewsRecords, $reviewsMetaData) = getRecords(array(
      'tableName'   => 'reviews',
      'where'     => "$review_type = '". mysql_escape($reviewID) ."'", 
      'loadUploads' => false,
      'allowSearch' => false,
    ));
  }
  if (!$pagesRecord['destination'] || !$pagesRecord['region']) {
    $hide_reviews = "1";
  } else {
    $hide_reviews = "0";
  }

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
  <title><?php echo htmlencode($pagesRecord['title']) ?> - <?php echo htmlencode($settingsRecord['company_name']) ?></title>
<?php include("includes/head.php"); ?>
  
  <?php 
    if ($pagesRecord['banner_image']) {
      foreach ($pagesRecord['banner_image'] as $index => $upload) {
        $hero_xl = ($upload['thumbUrlPath']);
        $hero_lg = ($upload['thumbUrlPath2']);
        $hero_md = ($upload['thumbUrlPath3']);
        break;
      }
      foreach ($pagesRecord['list_image'] as $index => $upload) {
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

<section class="hero">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <div class="content">
          <div class="hero-title-wrap">
            <h1 class="hero-title"><?php echo htmlencode($pagesRecord['heading']) ?></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="large-12 cell">

      <section class="section-page-tabs page-tabs<?php if (!$pagesRecord['tab_1'] && $hide_reviews ==1): ?> page-tabs-none<?php endif ?> padding-bottom-1">

        <ul class="tabs" data-active-collapse="true" data-allow-all-closed="true"data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-tabs" id="page-tabs">
          <?php if ($pagesRecord['tab_1'] || $hide_reviews != 1): ?><li class="tabs-title is-active"><a href="#tab_1" aria-selected="true"><?php if ($pagesRecord['tab_1']): ?><?php echo htmlencode($pagesRecord['tab_1']) ?><?php else: ?>Overview<?php endif ?></a></li><?php endif ?>
          <?php if ($pagesRecord['tab_2']): ?><li class="tabs-title"><a href="#tab_2"><?php echo htmlencode($pagesRecord['tab_2']) ?></a></li><?php endif ?>
          <?php if ($pagesRecord['tab_3']): ?><li class="tabs-title"><a href="#tab_3"><?php echo htmlencode($pagesRecord['tab_3']) ?></a></li><?php endif ?>
          <?php if ($pagesRecord['tab_4']): ?><li class="tabs-title"><a href="#tab_4"><?php echo htmlencode($pagesRecord['tab_4']) ?></a></li><?php endif ?>
          <?php if ($pagesRecord['tab_5']): ?><li class="tabs-title"><a href="#tab_5"><?php echo htmlencode($pagesRecord['tab_5']) ?></a></li><?php endif ?>
          <?php if ($hide_reviews != 1): ?><?php if ($reviewsRecords): ?><li class="tabs-title"><a href="#paneReviews">Reviews</a></li><?php endif ?><?php endif ?>
        </ul>

        <nav aria-label="You are here:" role="navigation" class="margin-top-1">
          <ul class="breadcrumbs">
            <li><a href="/">Home</a></li>
            <?php foreach ( $breadcrumbRecords as $breadcrumb ): ?>
              <li><?php if ( $breadcrumb['num'] != getLastNumberInUrl() ): ?><a href="<?php echo strtolower($breadcrumb['_link']); ?>"><?php endif ?> <?php echo $breadcrumb['name']; ?> <?php if ( $breadcrumb['num'] != getLastNumberInUrl() ): ?></a><?php endif ?></li>
            <?php endforeach ?>
          </ul>
        </nav>

        <div class="tabs-content" data-tabs-content="page-tabs">

          <div class="tabs-panel is-active" id="tab_1">
            <h2 class="tabs-panel-title"><?php echo htmlencode($pagesRecord['tab_1']) ?></h2>
            <?php echo $pagesRecord['content_1']; ?>
            <?php if ($pagesRecord['attachments_1']): ?> 
            <div class="sc-carousel carousel" data-flickity='{"fullscreen": true, "lazyLoad": 1, "pageDots": true, "cellAlign": "left", "wrapAround": true, "adaptiveHeight": true, "setGallerySize": false}'>
              <?php foreach ($pagesRecord['attachments_1'] as $index => $upload): ?>
              <div class="carousel-cell">
                <img 
                src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" data-flickity-lazyload="<?php echo htmlencode($upload['thumbUrlPath']) ?>"
                alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
              <?php endforeach ?>
            </div>
            <?php endif ?>
          </div>

          <?php if ($pagesRecord['tab_2']): ?>
          <div class="tabs-panel" id="tab_2">
            <h2 class="tabs-panel-title"><?php echo htmlencode($pagesRecord['tab_2']) ?></h2>
            <?php echo $pagesRecord['content_2']; ?>
            <?php if ($pagesRecord['attachments_2']): ?> 
            <div class="sc-carousel carousel" data-flickity='{"fullscreen": true, "lazyLoad": 1, "pageDots": true, "cellAlign": "left", "wrapAround": true, "adaptiveHeight": true, "setGallerySize": false}'>
              <?php foreach ($pagesRecord['attachments_2'] as $index => $upload): ?>
              <div class="carousel-cell">
                <img 
                src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" data-flickity-lazyload="<?php echo htmlencode($upload['thumbUrlPath']) ?>"
                alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
              <?php endforeach ?>
            </div>
            <?php endif ?>
          </div>
          <?php endif ?>

          <?php if ($pagesRecord['tab_3']): ?>
            <div class="tabs-panel" id="tab_3">
              <h2 class="tabs-panel-title"><?php echo htmlencode($pagesRecord['tab_3']) ?></h2>
              <?php echo $pagesRecord['content_3']; ?>
              <?php if ($pagesRecord['attachments_3']): ?> 
              <div class="sc-carousel carousel" data-flickity='{"fullscreen": true, "lazyLoad": 1, "pageDots": true, "cellAlign": "left", "wrapAround": true, "adaptiveHeight": true, "setGallerySize": false}'>
                <?php foreach ($pagesRecord['attachments_3'] as $index => $upload): ?>
                <div class="carousel-cell">
                  <img 
                  src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                  srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" data-flickity-lazyload="<?php echo htmlencode($upload['thumbUrlPath']) ?>"
                  alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
                <?php endforeach ?>
              </div>
              <?php endif ?>
            </div>
          <?php endif ?>

          <?php if ($pagesRecord['tab_4']): ?>
            <div class="tabs-panel" id="tab_4">
              <h2 class="tabs-panel-title"><?php echo htmlencode($pagesRecord['tab_4']) ?></h2>
              <?php echo $pagesRecord['content_4']; ?>
              <?php if ($pagesRecord['attachments_4']): ?> 
              <div class="sc-carousel carousel" data-flickity='{"fullscreen": true, "lazyLoad": 1, "pageDots": true, "cellAlign": "left", "wrapAround": true, "adaptiveHeight": true, "setGallerySize": false}'>
                <?php foreach ($pagesRecord['attachments_4'] as $index => $upload): ?>
                <div class="carousel-cell">
                  <img 
                  src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                  srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" data-flickity-lazyload="<?php echo htmlencode($upload['thumbUrlPath']) ?>"
                  alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
                <?php endforeach ?>
              </div>
              <?php endif ?>
            </div>
          <?php endif ?>

          <?php if ($pagesRecord['tab_5']): ?>
            <div class="tabs-panel" id="tab_5">
              <h2 class="tabs-panel-title"><?php echo htmlencode($pagesRecord['tab_5']) ?></h2>
              <?php echo $pagesRecord['content_5']; ?>
              <?php if ($pagesRecord['attachments_5']): ?> 
              <div class="sc-carousel carousel" data-flickity='{"fullscreen": true, "lazyLoad": 1, "pageDots": true, "cellAlign": "left", "wrapAround": true, "adaptiveHeight": true, "setGallerySize": false}'>
                <?php foreach ($pagesRecord['attachments_5'] as $index => $upload): ?>
                <div class="carousel-cell">
                  <img 
                  src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                  srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" data-flickity-lazyload="<?php echo htmlencode($upload['thumbUrlPath']) ?>"
                  alt="<?php echo htmlencode($upload['info1']) ?>" /></div>
                <?php endforeach ?>
              </div>
              <?php endif ?>
            </div>
          <?php endif ?>

          <?php if ($hide_reviews != 1): ?>
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
          <?php endif ?>

        </div>
        
      </section>

      <?php // Nav Drilldown
       list($subcatRecords, $subcatMetaData) = getCategories(array(    
       'tableName'   => 'pages',  
       'categoryFormat'      => 'showall', // showall, onelevel, twolevel, breadcrumb
       'loadUploads' => '1',
      ));

      $selectedCat = $pagesRecord['num'];
      $pagedepth = $pagesRecord['depth'];
      $pagedepthplusone = ++$pagedepth;

      ?>

      <section>
        <div class="content">
          <div class="content-cta text-center">
            <h3 class="content-cta-title">Explore more about sailing in <?php echo htmlencode($pagesRecord['name']) ?></h3>
          </div>
          <div class="card-list list-image-grid">

            <?php foreach ($subcatRecords as $subcat): ?>
              <?php if($subcat['parentNum']==$selectedCat && $subcat['depth'] == $pagedepthplusone): ?>
                <?php if($subcat['hide_nav']!=1):  // Check if hidden from nav ?>
                  <?php if ($subcat['redirect']) { $navlinkpage = strtolower($subcat['redirect']); } else { $navlinkpage = strtolower($subcat['_link']); } ?>
                  <div class="card">
                    <a href="<?php echo $navlinkpage ?>">
                      <div class="card-image">
                        <?php if ($subcat['list_image']): ?>
                        <?php foreach ($subcat['list_image'] as $index => $upload): ?>
                        <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" alt="<?php echo htmlencode($subcat['name']) ?>">
                        <?php endforeach ?>
                        <?php else: ?>
                        <img src="/img/no-image.png" alt="<?php echo htmlencode($subcat['name']) ?>">
                        <?php endif ?>
                      </div>
                      <div class="card-section">
                        <h3 class="card-title"><?php echo htmlspecialchars($subcat['name']);?></h3>
                      </div>
                    </a>
                  </div>
                <?php endif ?>
              <?php endif ?>
            <?php endforeach ?>

          </div>
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

</body>
</html>
