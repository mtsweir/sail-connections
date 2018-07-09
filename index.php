<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/dev.sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  list($homepageRecords, $homepageMetaData) = getRecords(array(
    'tableName'   => 'homepage',
    'where'       => '', // load first record
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $homepageRecord = @$homepageRecords[0]; // get first record
  if (!$homepageRecord) { dieWith404("Record not found!"); } // show error message if no record found

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
  <title><?php echo htmlencode($homepageRecord['title']) ?></title>
  <meta name="description" content="<?php echo htmlencode($homepageRecord['meta_description']) ?>">
  <link rel="canonical" href="<?php echo $settingsRecord['website_address'] ?>/">
<?php include("includes/head.php"); ?>
</head>

<body>

<?php include("includes/header.php"); ?>

<div class="hero-carousel section-inverse" data-flickity='{"wrapAround": true, "autoPlay": 3500}'>
  <?php foreach ($homepageRecord['slider_images'] as $index => $upload): ?>
  <div class="hero-carousel-cell">
    <div class="hero-carousel-cell-content">
      <h3 class="hero-carousel-title"><?php echo htmlencode($upload['info1']) ?></h3>
      <p><?php echo htmlencode($upload['info2']) ?></p>
      <a href="<?php echo htmlencode($upload['info4']) ?>" class="button secondary"><?php echo htmlencode($upload['info3']) ?></a>
    </div>
    <img src="<?php echo htmlencode($upload['thumbUrlPath']) ?>" alt="<?php echo htmlencode($upload['info1']) ?>">
  </div>
  <?php endforeach ?>
</div>

<?php include("includes/search.php"); ?>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="large-12 cell">

      <section>
        <div class="content">
          <div class="content-cta text-center">
            <h3 class="content-cta-title"><?php echo htmlencode($homepageRecord['heading']) ?></h3>
            <?php echo $homepageRecord['content_1']; ?>
          </div>
          <hr>
          <ul class="list-unstyled list-column list-column-2 list-column-features">
            <?php echo $homepageRecord['bullet_list']; ?>
          </ul>
          <hr>
          <div class="content-cta text-center">
            <?php echo $homepageRecord['content_2']; ?>
          </div>

          <?php 
            // load records from 'pages'
            list($homepage_featured_pagesRecords, $homepage_featured_pagesMetaData) = getRecords(array(
              'tableName'   => 'pages',
              'loadUploads' => true,
              'allowSearch' => false,
              'where'       => 'homepage_feature ="1"',
            ));
          ?>

          <div class="card-list">

            <?php foreach ($homepage_featured_pagesRecords as $record): ?>
            <div class="card">
              <a href="<?php echo $record['_link'] ?>">
                <div class="card-image">
                  <?php if ($record['list_image']) {
                      foreach ($record['list_image'] as $index => $upload) {
                        $feature_image = $upload['thumbUrlPath3'];
                        break;
                      }
                    } else {
                      $feature_image = "/img/no-image.png";
                    }
                  ?>
                  <img src="<?php echo $feature_image ?>" alt="<?php echo htmlencode($record['name']) ?>">
                </div>
                <div class="card-section">
                  <h3 class="card-title"><?php echo htmlencode($record['name']) ?></h3>
                </div>
              </a>
            </div>
            <?php endforeach ?>

          </div>

          <div class="content-cta text-center">
            <?php echo $homepageRecord['content_3']; ?>
          </div>

        </div>
      </section>

    </div><!-- large-12 cell -->
  </div><!-- grid-x grid-padding-x -->
</div><!-- grid-container -->


<section class="section-feature section-bg-grey">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="large-12 cell">
        <div class="content">

          <div class="content-cta text-center">
            <h3 class="content-cta-title"><?php echo htmlencode($homepageRecord['heading_destinations']) ?></h3>
          </div>
          <div class="card-list card-list-md-2 card-list-lg-4">
            <?php 
              // load records from 'pages'
              list($homepage_destinations_pagesRecords, $homepage_destinations_pagesMetaData) = getRecords(array(
                'tableName'   => 'pages',
                'loadUploads' => true,
                'allowSearch' => false,
                'where'       => 'homepage_destinations ="1"',
              ));
            ?>

            <?php foreach ($homepage_destinations_pagesRecords as $record): ?>
            <div class="card">
              <a href="<?php echo $record['_link'] ?>">
                <div class="card-image">
                  <?php if ($record['list_image']) {
                      foreach ($record['list_image'] as $index => $upload) {
                        $destinations_image = $upload['thumbUrlPath3'];
                        break;
                      }
                    } else {
                      $destinations_image = "/img/no-image.png";
                    }
                  ?>
                  <img src="<?php echo $destinations_image ?>" alt="<?php echo htmlencode($record['name']) ?>">
                </div>
                <div class="card-section">
                  <h3 class="card-title"><?php echo htmlencode($record['name']) ?></h3>
                </div>
              </a>
            </div>
            <?php endforeach ?>

          </div>

        </div><!-- content -->
      </div><!-- large-12 cell -->
    </div><!-- grid-x grid-padding-x -->
  </div><!-- grid-container -->
</section>

<section class="section-articles section-feature">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="cell">

        <div class="content">
          <div class="content-cta text-center">
            <h3 class="content-cta-title">Related Blog Posts</h3>
          </div>
          <ul class="article-list list-unstyled">
            <li class="article-list-item">
              <div class="article-list-image">
                <a href="#">
                  <img src="img/articles/article-sm.jpg">
                </a>
              </div>
              <div class="article-list-content">
                <a href="#" class="category-tag">Category</a>
                <h4 class="article-list-title">
                  <a href="#">A Sailing Holiday in Croatia</a>
                </h4>
                <p>Sail Connections’ Robert Cross recently took time out of the office for a two-week sailboat charter in Croatia. Here Robert reports on his sailing holiday adventure aboard a Dufour 350 travelling from Dubrovnik to Split return.</p>
              </div>
            </li>
            <li class="article-list-item">
              <div class="article-list-image">
                <a href="#">
                  <img src="img/articles/article-sm.jpg">
                </a>
              </div>
              <div class="article-list-content">
                <a href="#" class="category-tag">Category</a>
                <h4 class="article-list-title">
                  <a href="#">Chartering a sailboat with crew supplied</a>
                </h4>
                <p>A sailboat charter that includes a paid crew means one of two things: crewed bareboat with your party joined by freelance skipper and sometimes cook; or full-service charter on a boat with permanent, professional crew attached.</p>
              </div>
            </li>
            <li class="article-list-item">
              <div class="article-list-image">
                <a href="#">
                  <img src="img/articles/article-sm.jpg">
                </a>
              </div>
              <div class="article-list-content">
                <a href="#" class="category-tag">Category</a>
                <h4 class="article-list-title">
                  <a href="#">Your bareboat charter holiday in Croatia: what will it cost to stay in a marina?</a>
                </h4>
                <p>An ideal Croatian boat charter may mean overnighting in a quiet bay.Or perhaps hopping from town to town for fun and excitement. While the bay stopover may be free of charge, marina charges in Croatia can add up.</p>
              </div>
            </li>
          </ul>
          <div class="content-cta text-center">
            <a href="#" class="button secondary">View more blog posts</a>
          </div>
        </div>

      </div>
      <!-- large-12 cell -->
    </div>
    <!-- grid-x grid-padding-x -->
  </div>
  <!-- grid-container -->
</section>

<?php include("includes/footer-promo.php"); ?>
<?php include("includes/footer.php"); ?>

</body>
</html>
