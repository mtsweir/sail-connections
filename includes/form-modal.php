<!-- Modal -->
<div class="reveal large sc-modal" id="exampleModal1" data-reveal>
  <p class="lead text-center"><?php echo htmlencode($settingsRecord['form_title']) ?></p>
  <p class="subheader text-center"><?php echo htmlencode($settingsRecord['form_text']) ?></p>

  <?php include(dirname(__DIR__)."/includes/form.php"); ?>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<!-- END Modal -->