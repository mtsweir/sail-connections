<section class="search section-inverse section-bg-secondary-4">
  <form action="/yachts.php" method="get" id="yacht-search">
    <div class="grid-container">
      <div class="grid-x">
        <!-- <div class="cell medium-auto">
          <legend class="text-right middle">Yacht Search</legend>
        </div> -->
        <div class="cell medium-auto">
          <label for="searchDestination">Destination</label>
          <?php
            list($search_destination_listRecords, $destination_listMetaData) = getRecords(array(
              'tableName'   => 'destination_list',
              'loadUploads' => false,
              'allowSearch' => false,
            ));
          ?>
          <select id="searchDestination" name="destinations">
            <option selected disabled>Destination</option>
            <?php foreach ($search_destination_listRecords as $record): ?>
            <option value="<?php echo $record['num'] ?>" <?php selectedIf( $record['num'],  @$_REQUEST['destinations']) ?> >- <?php echo htmlspecialchars($record['destination']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="cell medium-auto">
          <label for="searchYachtType">Yacht Type</label>
          <?php
            list($search_yacht_type_listRecords, $yacht_typeMetaData) = getRecords(array(
            'tableName'   => 'yacht_type_list',
            'loadUploads' => false,
            'allowSearch' => false,
            ));
          ?>
          <select id="searchYachtType" name="yacht_type">
            <option selected disabled>Yacht Type</option>
            <?php foreach ($search_yacht_type_listRecords as $record): ?>
            <option value="<?php echo $record['num'] ?>" <?php selectedIf( $record['num'],  @$_REQUEST['yacht_type']) ?> >- <?php echo htmlspecialchars($record['yacht_type']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="cell medium-auto">
          <label for="searchCharterType">Charter Type</label>
          <?php
            list($search_charter_type_listRecords, $yacht_typeMetaData) = getRecords(array(
            'tableName'   => 'charter_type_list',
            'loadUploads' => false,
            'allowSearch' => false,
            ));
          ?>
          <select id="searchCharterType" name="charter_type">
            <option selected disabled>Charter Type</option>
            <?php foreach ($search_charter_type_listRecords as $record): ?>
            <option value="<?php echo $record['num'] ?>" <?php selectedIf( $record['num'],  @$_REQUEST['charter_type']) ?> >- <?php echo htmlspecialchars($record['charter_type']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="cell medium-4 large-3">
          <label for="searchKeyword">Keyword</label>
          <div class="input-group">
            <input class="input-group-field" type="text" id="searchKeyword" placeholder="Keyword..." name="yacht_name_query,meta_description_query,intro_query,description_query" value="<?php echo htmlspecialchars(@$_REQUEST['yacht_name_query,meta_description_query,intro_query,description_query']); ?>">
            <div class="input-group-button">
              <input type="submit" class="button secondary" value="Search">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>