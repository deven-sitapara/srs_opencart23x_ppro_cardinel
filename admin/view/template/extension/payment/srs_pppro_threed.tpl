<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pp-pro-uk" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pp-pro-uk" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-username"><?php echo $entry_username; ?></label>
            <div class="col-sm-10">
              <input type="text" name="srs_pppro_threed_username" value="<?php echo $srs_pppro_threed_username; ?>" placeholder="<?php echo $entry_username; ?>" id="entry-username" class="form-control"/>
              <?php if ($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="text" name="srs_pppro_threed_password" value="<?php echo $srs_pppro_threed_password; ?>" placeholder="<?php echo $entry_password; ?>" id="entry-password" class="form-control"/>
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-signature"><?php echo $entry_signature; ?></label>
            <div class="col-sm-10">
              <input type="text" name="srs_pppro_threed_signature" value="<?php echo $srs_pppro_threed_signature; ?>" placeholder="<?php echo $entry_signature; ?>" id="entry-signature" class="form-control"/>
              <?php if ($error_signature) { ?>
              <div class="text-danger"><?php echo $error_signature; ?></div>
              <?php } ?>
            </div>
          </div>



 
          <!-- Cardinel Centinel -->

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-signature"><?php echo $entry_centinel_processor_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="srs_pppro_threed_centinel_processor_id" value="<?php echo $srs_pppro_threed_centinel_processor_id; ?>" placeholder="<?php echo $entry_signature; ?>" id="entry-signature" class="form-control"/>
              <?php if ($error_centinel_processor_id) { ?>
              <div class="text-danger"><?php echo $error_centinel_processor_id; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-signature"><?php echo $entry_centinel_marchant_id; ?></label>
          <div class="col-sm-10"><input type="text" name="srs_pppro_threed_centinel_marchant_id" value="<?php echo $srs_pppro_threed_centinel_marchant_id; ?>" placeholder="<?php echo $entry_centinel_marchant_id; ?>" class="form-control" />
            <?php if ($error_centinel_marchant_id) { ?>
            <span class="text-danger"><?php echo $error_centinel_marchant_id; ?></span>
            <?php } ?>
          </div>
          </div>


      <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-signature"><?php echo $entry_centinel_transaction_pwd; ?></label>
          <div class="col-sm-10"><input type="text" name="srs_pppro_threed_centinel_transaction_pwd" value="<?php echo $srs_pppro_threed_centinel_transaction_pwd; ?>" placeholder="<?php echo $entry_centinel_transaction_pwd; ?>" class="form-control" />
            <?php if ($error_centinel_transaction_pwd) { ?>
            <span class="text-danger"><?php echo $error_centinel_transaction_pwd; ?></span>
            <?php } ?>
            </div>
          </div>



        <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry-signature"><?php echo $entry_centinel_maps_url; ?></label>
          <div class="col-sm-10"><input type="text" name="srs_pppro_threed_centinel_maps_url" value="<?php echo $srs_pppro_threed_centinel_maps_url; ?>" placeholder="<?php echo $entry_centinel_maps_url; ?>" class="form-control" />
            <?php if ($error_centinel_maps_url) { ?>
            <span class="text-danger"><?php echo $error_centinel_maps_url ; ?></span>
            <?php } ?></div>
          </div>





          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-live-demo"><span data-toggle="tooltip" title="<?php echo $help_test; ?>"><?php echo $entry_test; ?></span></label>
            <div class="col-sm-10">
              <select name="srs_pppro_threed_test" id="input-live-demo" class="form-control">
                <?php if ($srs_pppro_threed_test) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="srs_pppro_threed_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $srs_pppro_threed_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-transaction"><?php echo $entry_transaction; ?></label>
            <div class="col-sm-10">
              <select name="srs_pppro_threed_transaction" id="input-transaction" class="form-control">
                <?php if (!$srs_pppro_threed_transaction) { ?>
                <option value="0" selected="selected"><?php echo $text_authorization; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_authorization; ?></option>
                <?php } ?>
                <?php if ($srs_pppro_threed_transaction) { ?>
                <option value="1" selected="selected"><?php echo $text_sale; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_sale; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="srs_pppro_threed_total" value="<?php echo $srs_pppro_threed_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="srs_pppro_threed_sort_order" value="<?php echo $srs_pppro_threed_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="srs_pppro_threed_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $srs_pppro_threed_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="srs_pppro_threed_status" id="input-status" class="form-control">
                <?php if ($srs_pppro_threed_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>