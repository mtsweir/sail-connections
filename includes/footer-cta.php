<section class="section-feature section-bg-grey">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="large-12 cell">

        <div class="content">
          <div class="content-cta text-center">
            <h3 class="content-cta-title"><?php echo htmlencode($settingsRecord['cta_heading']) ?></h3>
            <p><?php echo htmlencode($settingsRecord['cta_subhead']) ?></p>
          </div>
          <hr>
          <ul class="list-unstyled list-column list-column-2 list-column-features">
            <?php echo $settingsRecord['cta_list_items'] ?>
          </ul>
          <hr>
          <div class="content-cta text-center">
            <p><?php echo htmlencode($settingsRecord['cta_closing']) ?></p>
            <a href="#" class="button button-icon-left secondary"><i class="sc-icon-mail" aria-hidden="true"></i> Get in Touch</a>
          </div>
        </div>

      </div><!-- large-12 cell -->
    </div><!-- grid-x grid-padding-x -->
  </div><!-- grid-container -->
</section>