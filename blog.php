<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
  /* STEP 1: LOAD RECORDS - Copy this PHP code block near the TOP of your page */
  
  // load viewer library
  $libraryPath = 'cms/lib/viewer_functions.php';
  $dirsToCheck = array('/home/sailconnections/sailconnections.com/','','../','../../','../../../');
  foreach ($dirsToCheck as $dir) { if (@include_once("$dir$libraryPath")) { break; }}
  if (!function_exists('getRecords')) { die("Couldn't load viewer library, check filepath in sourcecode."); }

  // load records from 'blog'
  list($blogRecords, $blogMetaData) = getRecords(array(
    'tableName'   => 'blog',
    'perPage'     => '15',
    'loadUploads' => true,
    'allowSearch' => true,
  ));

  // If Cat in URL, Get Blog Cat Record for Title & Banners
  if (@$_GET['category']) {  
  $catID = @$_GET['category'];
  // echo $catID;
  list($blog_categoriesRecords, $blog_categoriesMetaData) = getRecords(array(
    'tableName'   => 'blog_categories',
    'where'       => "num = '". mysql_escape($catID) ."'",
    'limit'       => '1',
    'useSeoUrls'    => false,
  ));
  $blog_categoriesRecord = @$blog_categoriesRecords[0]; // get first record
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

  include("includes/headers.php");

?><!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php if (@$_GET['category']): ?><?php echo htmlencode($blog_categoriesRecord['title']) ?><?php else: ?><?php echo htmlencode($settingsRecord['blog_title']) ?><?php endif ?> (Page <?php echo $blogMetaData['page'] ?>) - <?php echo htmlencode($settingsRecord['company_name']) ?></title>
  <meta name="description" content="">
  <?php if ($blogMetaData['prevPage']): ?>
  <link rel="prev" href="<?php echo $blogMetaData['prevPageLink'] ?>" />
  <?php endif ?>
  <?php if ($blogMetaData['nextPage']): ?>
  <link rel="next" href="<?php echo $blogMetaData['nextPageLink'] ?>" />
  <?php endif ?>
  <?php include("includes/head.php"); ?>
  
  <?php 
  if (@$_GET['category']) {
    if ($blog_categoriesRecord['banner_image']) {
      foreach ($blog_categoriesRecord['banner_image'] as $index => $upload) {
        $hero_xl = ($upload['thumbUrlPath']);
        $hero_lg = ($upload['thumbUrlPath2']);
        $hero_md = ($upload['thumbUrlPath3']);
        $hero_sm = ($upload['thumbUrlPath4']);
        break; 
      } 
    }
    elseif ($settingsRecord['blog_banner']) {
      foreach ($settingsRecord['blog_banner'] as $index => $upload) {
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
  } else {
    if ($settingsRecord['blog_banner']) {
      foreach ($settingsRecord['blog_banner'] as $index => $upload) {
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

<section class="hero">
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell">
        <div class="content">
          <div class="hero-title-wrap">
            <h1 class="hero-title">
            <?php if (@$_GET['category']): ?>
            <?php echo htmlencode($blog_categoriesRecord['title']) ?>
            <?php else: ?>
            <?php echo htmlencode($settingsRecord['blog_title']) ?>
            <?php endif ?>
            </h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="medium-9 cell">
    <section class="section-articles">
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
    
    <?php if (!$blogRecords): ?>
      No blog posts were found!<br/><br/>
    <?php endif ?>

    <nav aria-label="Pagination">
      <ul class="search-pagination list-unstyled">
        <?php if ($blogMetaData['prevPage']): ?>
          <li>
          <a class="button button-icon-left" href="<?php echo $blogMetaData['prevPageLink'] ?>" aria-label="Previous page">
            <i class="sc-icon-arrow-left"></i> Previous</a>
        </li><?php endif ?>
        <?php if ($blogMetaData['nextPage']): ?><li>
          <a class="button button-icon-right" href="<?php echo $blogMetaData['nextPageLink'] ?>" aria-label="Next page">Next <i class="sc-icon-arrow-right"></i></a>
        </li>
        <?php endif ?>
        
      </ul>
    </nav>


    </section>

    </div>

    <div class="medium-3 cell">
      <section class="section-articles">


      <table class="unstriped">
        <thead>
          <th>Blog Categories</th>
        </thead>
        

      <?php
        list($blog_categoriesRecords, $blog_categoriesMetaData) = getRecords(array(
          'tableName'   => 'blog_categories',
          'loadUploads' => false,
          'allowSearch' => false,
        ));
      ?>
      <tbody>
        <?php if (!@$_GET['category']): ?>
        <tr><td><a href="/blog/"><strong>Blog Home</strong></a></td></tr>
        <?php else: ?>
        <tr><td><a href="/blog/">Blog Home</a></td></tr>
        <?php endif ?>
        <?php foreach ($blog_categoriesRecords as $blogrecord): ?>
        <?php if (@$_GET['category'] == $blogrecord['num']): ?>
        <tr><td><a href="/blog/?category=<?php echo $blogrecord['num'] ?>"><strong><?php echo htmlencode($blogrecord['title']) ?></strong></a></td></tr>
        <?php else: ?>
        <tr><td><a href="/blog/?category=<?php echo $blogrecord['num'] ?>"><?php echo htmlencode($blogrecord['title']) ?></a></td></tr>
        <?php endif ?>
        <?php endforeach ?>
      </tbody>
      </table>

      </section>
    </div>

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
