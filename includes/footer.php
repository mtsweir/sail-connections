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

</div><!-- END Off-canvas Content -->

<!-- Modal -->
<div class="reveal large sc-modal" id="exampleModal1" data-reveal>
  <p class="lead">Enquire about this yacht</p>
  <p class="subheader">Receive a personalized proposal with boat, cost and extra options as applicable.</p>

  <form>
    <div class="grid-container full">
      <div class="grid-x grid-margin-x">
        <div class="medium-4 cell">
          <label>First Name:
            <input type="text" placeholder="First name">
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Last Name:
            <input type="text" placeholder="Last name">
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Email Address:
            <input type="text" placeholder="Email address">
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Your Phone Number:
            <input type="text" placeholder="Phone number">
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Charter Destination:
            <input type="text" placeholder="Charter destination">
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Yacht Preference:
            <select>
              <option selected disabled>Please select...</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </label>
        </div>
        <div class="medium-4 cell">
          <label>When and for how long:
            <input type="text" placeholder="When and for how long">
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Your Budget:
            <input type="text" placeholder="Your budget">
          </label>
        </div>
        <div class="cell">
          <label>
             Comments:
            <textarea rows="4"></textarea>
          </label>
        </div>
        <div class="cell">
          <button class="button secondary form-button">Send Request</button>
        </div>
      </div>
    </div>
  </form>


  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<!-- END Modal -->
<!-- Core Scripts -->
<script src="/node_modules/jquery/dist/jquery.js"></script>
<script src="/node_modules/what-input/dist/what-input.js"></script>
<script src="/node_modules/foundation-sites/dist/js/foundation.js"></script>
<script src="/js/min/app-min.js"></script>
<!-- Vendor Scripts -->
<script src="/node_modules/flickity/dist/flickity.pkgd.min.js"></script>
<script src="/node_modules/flickity-fullscreen/fullscreen.js"></script>