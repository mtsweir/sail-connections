<section class="padding-bottom-3">

  <form id="form-guide" name="form-guide" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post"
      action="https://sailconn.wufoo.com/forms/zubwxe10i0rvf1/#public">

      <div class="grid-x grid-margin-x feature-box margin-bottom-1">
        
        <div class="medium-4 cell">
          <label for="Field1">First Name:
          <input id="Field1" name="Field1" type="text" placeholder="First name" required /></label>
        </div>

        <div class="medium-4 cell">
          <label for="Field2">Last Name:
          <input id="Field2" name="Field2" type="text" placeholder="Last name" required /></label>
        </div>
        
        <div class="medium-4 cell">
          <label for="Field3">Email:
          <input id="Field3" name="Field3" type="email" placeholder="Email address" required /></label>
        </div>

      </div>

      <div class="cell text-center">

        <input id="Field10" name="Field10" type="checkbox" value="TRUE">
        <label for="Field10"><?php echo htmlencode($settingsRecord['form_subscribe']) ?></label>

        <label class="hide hidden" for="Field117">Market (Please leave blank)
        <input id="Field117" name="Field117" type="text" value="<?php echo $market ?>" /></label>

        <div class="hide">
        <label for="comment">Do Not Fill This Out</label>
        <textarea name="comment" id="comment" rows="1" cols="1"></textarea>
        <input type="hidden" id="idstamp" name="idstamp" value="FEA2yG3zzsjJwIvwVklKhq+GiMfiRHJIAXbDNyBxftw=" />
        </div>

      </div>

      <div class="cell text-center">

        <button class="button secondary form-button">Download</button>

      </div>

    </form>
</section>



