<footer class="footer">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="large-12 cell">

        <div class="content text-center">
          <nav>
            <ul class="footer-nav list-unstyled list-inline padding-bottom-1 margin-bottom-2">
            <?php foreach ($pagesRecords as $record): ?>
            <?php if($record['hide_nav']==0):  // Check if hidden from nav ?>
              <?php if($record['depth']==0):  // Only show top level ?>
                <?php echo $record['_listItemStart']; ?>
                <?php $navlink = ($record['redirect'])? strtolower($record['redirect']) : strtolower($record['_link']); ?>
                  <a href="<?php echo $navlink ?>"><?php echo htmlspecialchars($record['name']);?></a>
                <?php echo $record['_listItemEnd']; ?>
              <?php endif ?>
            <?php endif ?>
            <?php endforeach ?> 
            </ul>
            <ul class="footer-nav-social list-unstyled list-inline">
              <?php if ($settingsRecord['facebook']): ?>
              <li>
                <a href="<?php echo htmlencode($settingsRecord['facebook']) ?>">
                  <span class="show-for-sr">Facebook</span>
                  <i class="sc-icon-facebook" aria-hidden="true"></i>
                </a>
              </li>
              <?php endif ?>
              <?php if ($settingsRecord['twitter']): ?>
              <li>
                <a href="<?php echo htmlencode($settingsRecord['twitter']) ?>">
                  <span class="show-for-sr">Twitter</span>
                  <i class="sc-icon-twitter" aria-hidden="true"></i>
                </a>
              </li>
              <?php endif ?>
              <?php if ($settingsRecord['instagram']): ?>
              <li>
                <a href="<?php echo htmlencode($settingsRecord['instagram']) ?>">
                  <span class="show-for-sr">Instagram</span>
                  <i class="sc-icon-instagram" aria-hidden="true"></i>
                </a>
              </li>
              <?php endif ?>
              <?php if ($settingsRecord['linkedin']): ?>
              <li>
                <a href="<?php echo htmlencode($settingsRecord['linkedin']) ?>">
                  <span class="show-for-sr">Linkedin</span>
                  <i class="sc-icon-linkedin" aria-hidden="true"></i>
                </a>
              </li>
              <?php endif ?>
            </ul>
          </nav>
        </div>

      </div><!-- large-12 cell -->
    </div><!-- grid-x grid-padding-x -->
  </div><!-- grid-container -->
</footer>
