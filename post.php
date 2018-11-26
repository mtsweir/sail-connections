<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // load record from 'blog'
  list($blogRecords, $blogMetaData) = getRecords(array(
    'tableName'   => 'blog',
    'where'       => whereRecordNumberInUrl(0),
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $blogRecord = @$blogRecords[0]; // get first record
  if (!$blogRecord) { dieWith404("Record not found!"); } // show error message if no record found

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
  <title><?php echo htmlencode($blogRecord['title']) ?> - <?php echo htmlencode($settingsRecord['company_name']) ?></title>
  <meta name="description" content="<?php echo htmlencode($blogRecord['meta_description']) ?>">
  <link rel="canonical" href="<?php echo $settingsRecord['website_address'] ?><?php echo $blogRecord['_link'] ?>">
<?php include("includes/head.php"); ?>
  
  <?php 
    if ($blogRecord['banner_image']) {
      foreach ($blogRecord['banner_image'] as $index => $upload) {
        $hero_xl = ($upload['thumbUrlPath']);
        $hero_lg = ($upload['thumbUrlPath2']);
        $hero_md = ($upload['thumbUrlPath3']);
        break;
      }
      foreach ($blogRecord['list_image'] as $index => $upload) {
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

<section class="hero<?php if (!$blogRecord['banner_image']): ?> no-hero<?php endif ?>">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <div class="content">
          <div class="hero-title-wrap">
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="medium-8 medium-offset-2 cell">

      <section class="article">

        <nav aria-label="You are here:" role="navigation" class="breadcrumbs-wrapper">
          <ul class="breadcrumbs">
            <li><a href="/">Home</a></li>
            <li><a href="/blog/">Blog</a></li>
            <li><span class="show-for-sr">Current: </span> <?php echo htmlencode($blogRecord['title']) ?></li>
          </ul>
        </nav>

        <article>
          
          <header>
            <h1><?php echo htmlencode($blogRecord['title']) ?></h1>
            <div class="meta">
              <span class="meta-byline">Date: <?php echo date("D, M jS, Y", strtotime($blogRecord['publishDate'])) ?></span>
              <?php if ($blogRecord['category']||$blogRecord['destination_primary']): ?>

              <span class="meta-category">Posted In: 

              <?php if ($blogRecord['category']): ?>
                  <?php  // load records from 'blog_categories'
                  $destID = " " . $blogRecord['category'] . " ";
                  list($blog_categoriesRecords, $blog_categoriesMetaData) = getRecords(array(
                  'tableName'   => 'blog_categories',
                  'loadUploads' => false,
                  'allowSearch' => false,
                  'where'       => "'". mysql_escape($destID) ."' LIKE CONCAT('%\t', num ,'\t%') " . ' AND hidden ="0"', 
                  ));
                  ?>
                  <?php $countD=0; ?>
                      <?php foreach ($blog_categoriesRecords as $record): ?>
                        <?php echo ($countD==0)? "" : ", " ?>
                          <a href="/blog/?category=<?php echo $record['num'] ?>"><?php echo htmlencode($record['title']) ?></a>
                        <?php $countD++;?>
                    <?php endforeach ?>
              <?php endif ?>

              <?php if ($blogRecord['destination_primary']): ?>
                  <?php if ($blogRecord['category']): ?>, <?php endif ?>
                  <?php  // load records from 'destinations'
                  // $destID = " " . $blogRecord['destinations'] . " ";
                  $destID = $blogRecord['destination_primary'];
                  list($destination_listRecords, $destination_listMetaData) = getRecords(array(
                  'tableName'   => 'destination_list',
                  'loadUploads' => false,
                  'allowSearch' => false,
                  // 'where'       => "'". mysql_escape($destID) ."' LIKE CONCAT('%\t', num ,'\t%') " . ' AND hidden ="0"', 
                  'where'       => "num = '". mysql_escape($destID) ."'",
                  ));
                  ?>
                  <?php $countD=0; ?>
                      <?php foreach ($destination_listRecords as $record): ?>
                        <?php echo ($countD==0)? "" : ", " ?>
                        <?php if ($record['destination_link']): ?>
                          <a href="/<?php echo $record['destination_link'] ?>/"><?php echo htmlencode($record['destination']) ?></a>
                        <?php endif ?>
                        <?php $countD++;?>
                    <?php endforeach ?>
              <?php endif ?>
              </span>

              <?php endif ?>
            </div>
          </header>

          <?php if ($blogRecord['intro']): ?><p class="text-lead"><?php echo $blogRecord['intro']; ?></p><?php endif ?>

          <?php echo $blogRecord['content_1']; ?>
          
          <?php if ($blogRecord['images_1']): ?>
          <div class="card-list list-image-grid">
            <?php foreach ($blogRecord['images_1'] as $index => $upload): ?>

                  <div class="card">
                      <div class="card-image">
                      <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                      srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" 
                      alt="<?php echo htmlencode($upload['info1']) ?>" />
                      </div>
                      <div class="card-section">
                        <p class="card-title"><?php echo htmlencode($upload['info1']) ?></p>
                      </div>
                  </div>

            <?php endforeach ?>
          </div>
          <?php endif ?>

          <?php echo htmlencode($blogRecord['media_embed_1']) ?>

          <?php echo $blogRecord['content_2']; ?>

          <?php if ($blogRecord['images_2']): ?>
          <div class="card-list list-image-grid">
            <?php foreach ($blogRecord['images_2'] as $index => $upload): ?>

                  <div class="card">
                      <div class="card-image">
                      <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                      srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" 
                      alt="<?php echo htmlencode($upload['info1']) ?>" />
                      </div>
                      <div class="card-section">
                        <p class="card-title"><?php echo htmlencode($upload['info1']) ?></p>
                      </div>
                  </div>

            <?php endforeach ?>
          </div>
          <?php endif ?>

          <?php echo $blogRecord['content_3']; ?>

          <?php if ($blogRecord['images_3']): ?>
          <div class="card-list list-image-grid">
            <?php foreach ($blogRecord['images_3'] as $index => $upload): ?>

                  <div class="card">
                      <div class="card-image">
                      <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                      srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" 
                      alt="<?php echo htmlencode($upload['info1']) ?>" />
                      </div>
                      <div class="card-section">
                        <p class="card-title"><?php echo htmlencode($upload['info1']) ?></p>
                      </div>
                  </div>

            <?php endforeach ?>
          </div>
          <?php endif ?>

          <?php echo $blogRecord['content_4']; ?>

          <?php if ($blogRecord['images_4']): ?>
          <div class="card-list list-image-grid">
            <?php foreach ($blogRecord['images_4'] as $index => $upload): ?>

                  <div class="card">
                      <div class="card-image">
                      <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                      srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" 
                      alt="<?php echo htmlencode($upload['info1']) ?>" />
                      </div>
                      <div class="card-section">
                        <p class="card-title"><?php echo htmlencode($upload['info1']) ?></p>
                      </div>
                  </div>

            <?php endforeach ?>
          </div>
          <?php endif ?>

          <?php echo $blogRecord['content_5']; ?>

          <?php if ($blogRecord['images_5']): ?>
          <div class="card-list list-image-grid">
            <?php foreach ($blogRecord['images_5'] as $index => $upload): ?>

                  <div class="card">
                      <div class="card-image">
                      <img src="<?php echo htmlencode($upload['thumbUrlPath3']) ?>" 
                      srcset="<?php echo htmlencode($upload['thumbUrlPath2']) ?> 1000w, <?php echo htmlencode($upload['thumbUrlPath']) ?> 2000w" 
                      alt="<?php echo htmlencode($upload['info1']) ?>" />
                      </div>
                      <div class="card-section">
                        <p class="card-title"><?php echo htmlencode($upload['info1']) ?></p>
                      </div>
                  </div>

            <?php endforeach ?>
          </div>
          <?php endif ?>

          <?php echo htmlencode($blogRecord['media_embed_2']) ?>

          <?php echo $blogRecord['content_6']; ?>

        </article>
        <aside class="article-sidebar text-center">
          <div class="content-cta">
            <a href="<?php echo $settingsRecord['contact_link'] ?>" class="button button-icon-left">
               Have Questions? <i class="sc-icon-arrow-right"></i> Get in touch...
            </a>
          </div>
        </aside>

      </section>

    </div><!-- large-12 cell -->
  </div><!-- grid-x grid-padding-x -->
</div><!-- grid-container -->

<?php 
  // load records from 'blog'
  $thisblogID = $blogRecord['num'];

  if ($blogRecord['destination_primary']) {
    $thisblogCAT = $blogRecord['destination_primary']; 
    list($blogRecords, $blogMetaData) = getRecords(array(
      'tableName'   => 'blog',
      'limit'       => '5',
      'loadUploads' => true,
      'allowSearch' => false,
      'where'       => "num !='". mysql_escape($thisblogID) ."'" . " AND destination_primary LIKE '". mysql_escape($thisblogCAT) ."'",
    ));
  } elseif ($blogRecord['category']) {
    $thisblogCAT = $blogRecord['category'];
    list($blogRecords, $blogMetaData) = getRecords(array(
      'tableName'   => 'blog',
      'limit'       => '5',
      'loadUploads' => true,
      'allowSearch' => false,
      'where'       => "num !='". mysql_escape($thisblogID) ."'" . " AND category LIKE '". mysql_escape($thisblogCAT) ."'",
    ));
  } else {
    list($blogRecords, $blogMetaData) = getRecords(array(
      'tableName'   => 'blog',
      'limit'       => '5',
      'loadUploads' => true,
      'allowSearch' => false,
      'where'       => "num !='". mysql_escape($thisblogID) ."'",
    ));
  }
?>

<?php if ($blogRecords): ?>

<section class="section-articles">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="cell">

        <div class="content">
          <h3 class="article-list-header text-center">Related Blog Posts</h3>
          <ul class="article-list list-unstyled">
            
            <?php foreach ($blogRecords as $record): ?>
              <li class="article-list-item">
              <div class="article-list-image">
                <a href="<?php echo $record['_link'] ?>">
                  <?php foreach ($record['list_image'] as $index => $upload): ?><img src="<?php echo htmlencode($upload['thumbUrlPath']) ?>" alt="<?php echo htmlencode($record['title']) ?>"></a><?php endforeach ?>
              </div>
              <div class="article-list-content">
                <h4 class="article-list-title"><a href="<?php echo $record['_link'] ?>"><?php echo htmlencode($record['title']) ?></a></h4>
                <p><?php if ($record['meta_description']): ?><?php echo htmlencode($record['meta_description']) ?><?php else: ?><?php echo htmlencode($record['intro']) ?><?php endif ?></p>
              </div>
            </li>
            <?php endforeach ?>

          </ul>
          <div class="content-cta text-center">
            <a href="<?php echo $settingsRecord['blog_link'] ?>" class="button secondary">View more blog posts...</a>
          </div>
        </div>

      </div>
      <!-- large-12 cell -->
    </div>
    <!-- grid-x grid-padding-x -->
  </div>
  <!-- grid-container -->
</section>
<?php endif ?>

<?php include("includes/footer-cta.php"); ?>
<?php include("includes/footer-promo.php"); ?>
<?php include("includes/footer.php"); ?>

</div><!-- END Off-canvas Content -->

<?php include("includes/form-modal.php"); ?>
<?php include("includes/footer-scripts.php"); ?>

</body>
</html>
