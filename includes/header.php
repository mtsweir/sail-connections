<?php
  // load records from 'pages'
  list($pagesRecords, $selectedPages) = getCategories(array(
    'tableName'            => 'pages', //
    'categoryFormat'       => 'twolevel',  // showall, onelevel, twolevel, breadcrumb
    'defaultCategory'      => '',    // Enter 'first', a category number, or leave blank '' for none
    
    // advanced options (you can safely ignore these)
    'rootCategoryNum'      => '0',      // Only categories _below_ this one will be shown (defaults to blank or 0 for all)
    'ulAttributes'         => '',      // add html attributes to <ul> tags, eg: 'class="menuUL"' would output <ul class="menuUL">
    'selectedCategoryNum'  => '0',      // this record number is returned as the "selected category", defaults to getLastNumberInUrl()
    'ulAttributesCallback' => '',      // ADVANCED: custom function to return ul attributes, eg: 'myUlAttr' and function myUlAttr($category) { return "id='ul_uniqueId_{$category['num']}'"; }
    'liAttributesCallback' => '',      // ADVANCED: custom function to return li attributes, eg: 'myLiAttr' and function myLiAttr($category) { return "id='li_uniqueId_{$category['num']}'"; }
    'loadCreatedBy'        => false,   // loads createdBy.* fields for user who created category record (false is faster)
    'loadUploads'          => false,    // loads upload fields, eg: $category['photos'] gets defined with array of uploads (false is faster)
    'ignoreHidden'         => false,   // false = hide records with 'hidden' flag set, true = ignore status of hidden flag when loading records
    'debugSql'             => false,   // display the MySQL query being used to load records (for debugging)
  ));
?>
<!-- Off-canvas Menu -->
<div class="off-canvas sc-off-canvas position-right" id="offCanvas" data-off-canvas>

  <!-- Close toggle -->
  <span role="button" class="close-button" href="#" aria-label="Close menu" data-close>
    <i class="sc-icon-menu" aria-hidden="true"></i>
  </span>

  <!-- Mobile Menu -->
  <ul class="vertical menu accordion-menu" data-accordion-menu>
    <li aria-hidden="true"><hr></li>
    <li><a href="/">Home</a></li>

    <?php foreach ($pagesRecords as $record): ?>
    <?php if($record['hide_nav']==0):  // Check if hidden from nav ?>
    <?php 
      if($record['depth'] == '1' && $record['_isFirstChild']){
        $record['_listItemStart'] = str_replace('<ul>', '<ul class="menu vertical nested">', $record['_listItemStart']);
      }
      if($record['depth'] == '1' && $record['_isLastChild'] && $record['_hasParent']){
        $record['_listItemEnd'] = str_replace('</ul>', '</ul>', $record['_listItemEnd']);
      }
      echo $record['_listItemStart'];
    ?>
    <?php $navlink = ($record['redirect'])? strtolower($record['redirect']) : strtolower($record['_link']); ?>
        <a href="<?php echo $navlink ?>"><?php echo htmlspecialchars($record['name']);?></a>
    <?php echo $record['_listItemEnd']; ?>
    <?php endif ?>
    <?php endforeach ?> 

    <li aria-hidden="true"><hr></li>
    <li class="oc-menu-social">
      <?php if ($settingsRecord['facebook']): ?>
        <a href="<?php echo htmlencode($settingsRecord['facebook']) ?>">
        <span class="show-for-sr">Facebook</span>
        <i class="sc-icon-facebook" aria-hidden="true"></i>
      </a>
      <?php endif ?>
      <?php if ($settingsRecord['twitter']): ?>
      <a href="<?php echo htmlencode($settingsRecord['twitter']) ?>">
        <span class="show-for-sr">Twitter</span>
        <i class="sc-icon-twitter" aria-hidden="true"></i>
      </a>
      <?php endif ?>
      <?php if ($settingsRecord['instagram']): ?>
      <a href="<?php echo htmlencode($settingsRecord['instagram']) ?>">
        <span class="show-for-sr">Instagram</span>
        <i class="sc-icon-instagram" aria-hidden="true"></i>
      </a>
      <?php endif ?>
      <?php if ($settingsRecord['linkedin']): ?>
      <a href="<?php echo htmlencode($settingsRecord['linkedin']) ?>">
        <span class="show-for-sr">Linkedin</span>
        <i class="sc-icon-linkedin" aria-hidden="true"></i>
      </a>
      <?php endif ?>
    </li>
  </ul>

</div>

<!-- Off-canvas Content -->
<div class="off-canvas-content" data-off-canvas-content>

<header class="sc-header">
  <div class="top-bar">
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu>
        <li class="menu-text">
          <a href="/"><img class="logo" src="/img/sc-logo.svg" alt="Sail Connections"></a>
        </li>

        <?php foreach ($pagesRecords as $record): ?>
        <?php if($record['hide_nav']==0):  // Check if hidden from nav ?>
        <?php 
          if($record['depth'] == '1' && $record['_isFirstChild']){
            $record['_listItemStart'] = str_replace('<ul>', '<ul class="menu vertical">', $record['_listItemStart']);
          }
          if($record['depth'] == '1' && $record['_isLastChild'] && $record['_hasParent']){
            $record['_listItemEnd'] = str_replace('</ul>', '</ul>', $record['_listItemEnd']);
          }
          if($record['depth'] == '0') {
            $record['_listItemStart'] = str_replace('<li>', '<li class="show-for-large">', $record['_listItemStart']);
          }
          echo $record['_listItemStart'];
        ?>
        <?php $navlink = ($record['redirect'])? strtolower($record['redirect']) : strtolower($record['_link']); ?>
            <a href="<?php echo $navlink ?>"><?php echo htmlspecialchars($record['name']);?></a>
        <?php echo $record['_listItemEnd']; ?>
        <?php endif ?>
        <?php endforeach ?> 

      </ul>
    </div>
    <div class="top-bar-right">
      <ul class="menu">
        <li>
          <a class="button button-secondary-2 button-icon-left" href="#" data-open="exampleModal1">
            <i class="sc-icon-mail" aria-hidden="true"></i>
            <span class="button-text">Enquire</span>
          </a>
        </li>
        <li class="hide-for-large">
          <button type="button" class="button button-secondary-3 button-icon-left" data-toggle="offCanvas">
            <i class="sc-icon-menu" aria-hidden="true"></i>
            <span class="button-text">Menu</span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</header>