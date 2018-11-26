  <form id="form6" name="form6" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post"
      action="https://sailconn.wufoo.com/forms/w1u6luy70argezp/#public">
    <div class="grid-container full">
      <div class="grid-x grid-margin-x">
        <div class="medium-4 cell">
          <label>First Name:
            <input id="Field1" name="Field1" type="text" maxlength="255" placeholder="First name" required />
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Last Name:
            <input id="Field2" name="Field2" type="text" maxlength="255" placeholder="Last name" required />
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Email Address:
            <input id="Field3" name="Field3" type="email" maxlength="255" placeholder="Email address" required  spellcheck="false" />
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Phone Number:
            <input id="Field4" name="Field4" type="tel"  maxlength="255" placeholder="Phone number" />
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Charter Destination:
            <input id="Field113" name="Field113" type="text" maxlength="255" placeholder="Charter destination" />
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Yacht Preference:
			<select id="Field5" name="Field5">
			<option value="" selected="selected">Please select...</option>
			<option value="Monohull - 36 to 40&#039;" >Monohull - 36 to 40'</option>
			<option value="Monohull - 40 to 45&#039;" >Monohull - 40 to 45'</option>
			<option value="Monohull - 45 to 50&#039;" >Monohull - 45 to 50'</option>
			<option value="Monohull - Over 50&#039;" >Monohull - Over 50'</option>
			<option value="Catamaran - 36 to 40&#039;" >Catamaran - 36 to 40'</option>
			<option value="Catamaran - 40 to 45&#039;" >Catamaran - 40 to 45'</option>
			<option value="Catamaran - 45 to 50&#039;" >Catamaran - 45 to 50'</option>
			<option value="Catamaran - Over 50&#039;" >Catamaran - Over 50'</option>
			</select>
          </label>
        </div>
        <div class="medium-4 cell">
          <label>When and for how long:
            <input id="Field6" name="Field6" type="text" maxlength="255" placeholder="When and for how long" />
          </label>
        </div>
        <div class="medium-4 cell">
          <label>Your Budget:
            <input id="Field8" name="Field8" type="text" maxlength="255" placeholder="Your budget" />
          </label>
        </div>
        <div class="cell">
          <label>
             Comments:
            <textarea id="Field9" name="Field9" rows="4" spellcheck="true" required></textarea>
          </label>
        </div>
        <div class="cell text-center">
        <input id="Field10" name="Field10" type="checkbox" value="TRUE">
        <label for="Field10"><?php echo htmlencode($settingsRecord['form_subscribe']) ?></label>
    	   </div>
        <div class="cell text-center">

          <button class="button secondary form-button">Send Request</button>


          <label class="hide hidden" for="Field111">Page URL (Do Not Fill This Out)
          <?php $pageurl  = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
          <input id="Field111" name="Field111" type="text" value="<?php echo $pageurl ?>" maxlength="255" /></label>

          <label class="hide hidden" for="Field15">IP address (Do Not Fill This Out)
          <?php $ipaddress = $_SERVER['REMOTE_ADDR']; ?>
          <input id="Field115" name="Field115" type="text" value="http://whatismyipaddress.com/ip/<?php echo $ipaddress ?>" maxlength="255" /></label>

          <label class="hide hidden" for="Field117">Market (Do Not Fill This Out)
          <input id="Field117" name="Field117" type="text" value="<?php echo $market ?>" maxlength="255" /></label>


          <?php 
          // See: https://www.terminusapp.com/blog/add-utm-referrer-lead-forms/ 
          // https://www.linkedin.com/pulse/how-justify-your-marketing-budget-using-data-minimal-effort-jave-lin/
          ?>

          <label class="hide hidden" for="Field119">USOURCE (Do Not Fill This Out)
          <input id="Field119" name="Field119" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field120">UMEDIUM (Do Not Fill This Out)
          <input id="Field120" name="Field120" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field121">UCAMPAIGN (Do Not Fill This Out)
          <input id="Field121" name="Field121" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field122">UCONTENT (Do Not Fill This Out)
          <input id="Field122" name="Field122" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field123">UTERM (Do Not Fill This Out)
          <input id="Field123" name="Field123" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field124">IREFERRER (Do Not Fill This Out)
          <input id="Field124" name="Field124" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field125">LREFERRER (Do Not Fill This Out)
          <input id="Field125" name="Field125" type="text" value="" maxlength="255" /></label>

          <label class="hide hidden" for="Field126">ILANDPAGE (Do Not Fill This Out)
          <input id="Field126" name="Field126" type="text" value="" maxlength="255" /></label>


          <label class="hide hidden" for="comment">Do Not Fill This Out
          <textarea name="comment" id="comment" rows="1" cols="1"></textarea>
          <input type="hidden" id="idstamp" name="idstamp" value="tLSyiyVBzfX7ZYu7oVLbYAwV19r5Okh+gEqpBrP4HPg=" />

        </div>
      </div>
    </div>
  </form>