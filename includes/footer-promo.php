<?php if ($settingsRecord['show_footer_promo'] == 1): ?>
<section class="section-feature-guide section-feature section-feature-image section-inverse">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="large-12 cell">

        <div class="content content-overlay text-center">
          <div class="content-cta">
            <h3 class="content-cta-title"><?php echo htmlencode($settingsRecord['promo_heading']) ?></h3>
            <p><?php echo htmlencode($settingsRecord['promo_description']) ?></p>
            <a href="<?php echo $settingsRecord['promo_link'] ?>" class="button"><?php echo htmlencode($settingsRecord['promo_button_text']) ?></a>
          </div>
        </div>

      </div><!-- large-12 cell -->
    </div><!-- grid-x grid-padding-x -->
  </div><!-- grid-container -->
</section>
<?php endif ?>