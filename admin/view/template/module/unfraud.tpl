<?php echo $header; ?>
<?php switch($version){

 case "2": ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-unfraud" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-check-circle"></i></button>
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
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-unfraud" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-button-type"><?php echo $entry_apikey; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo $unfraud_apikey; ?>" style="width:250px" name="unfraud_apikey">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-button-type"><?php echo $entry_email; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo $unfraud_email; ?>" style="width:250px" name="unfraud_email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-button-type"><?php echo $entry_password; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo $unfraud_password; ?>" style="width:250px" name="unfraud_password">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label class="col-sm-2 control-label" for="input-button-type"><?php echo $entry_threshold; ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo $unfraud_threshold?$unfraud_threshold:100; ?>" style="width:250px" name="unfraud_threshold">
                        </div>
                    </div>-->
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> Unfraud Dashboard</h3>
            </div>
            <div class="panel-body">
            <?php
                if($unfraud_email && $unfraud_password && $unfraud_apikey ){

                    $contents = json_decode(file_get_contents($unfraud_login_api_url.'&email='.$unfraud_email.'&password='.$unfraud_password),true);
                    if($contents["status"]=="logged"){
                        echo '<iframe src="'.$unfraud_login_url.'?e='.$unfraud_email.'&p='.$unfraud_password.'&t='.$unfraud_apikey.'" width="100%" height="1000" style="border:1px lightGray solid" frameborder="0"></iframe>';
                    }
                    else{
                        echo $entry_credentials_error;
                    }
                }
                else{
                    echo $entry_configuration_error;
                }
            ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="unfraud_module[' + module_row + '][limit]" value="5" size="1" /></td>';
	html += '    <td class="left"><input type="text" name="unfraud_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="unfraud_module[' + module_row + '][image_height]" value="80" size="3" /></td>';
	html += '    <td class="left"><select name="unfraud_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="unfraud_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="unfraud_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="unfraud_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>
<?php break;
default:
?>
<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content" style="min-height:100px">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><?php echo $entry_apikey; ?></td>
                        <td><input type="text" value="<?php echo $unfraud_apikey; ?>" style="width:250px" name="unfraud_apikey"></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_email; ?></td>
                        <td><input type="text" value="<?php echo $unfraud_email; ?>"  style="width:250px" name="unfraud_email"></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_password; ?></td>
                        <td><input type="password" value="<?php echo $unfraud_password; ?>"  style="width:250px" name="unfraud_password"></td>
                    </tr>
                </table>

                <table id="module" class="list" style="display: none;">
                    <thead>
                    <tr>
                        <td class="left"><?php echo $entry_limit; ?></td>
                        <td class="left"><?php echo $entry_image; ?></td>
                        <td class="left"><?php echo $entry_layout; ?></td>
                        <td class="left"><?php echo $entry_position; ?></td>
                        <td class="left"><?php echo $entry_status; ?></td>
                        <td class="right"><?php echo $entry_sort_order; ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <?php $module_row = 0; ?>
                    <?php foreach ($modules as $module) { ?>
                    <tbody id="module-row<?php echo $module_row; ?>">
                    <tr>
                        <td class="left"><input type="text" name="unfraud_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" /></td>
                        <td class="left"><input type="text" name="unfraud_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
                            <input type="text" name="unfraud_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
                            <?php if (isset($error_image[$module_row])) { ?>
                            <span class="error"><?php echo $error_image[$module_row]; ?></span>
                            <?php } ?></td>
                        <td class="left"><select name="unfraud_module[<?php echo $module_row; ?>][layout_id]">
                                <?php foreach ($layouts as $layout) { ?>
                                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select></td>
                        <td class="left"><select name="unfraud_module[<?php echo $module_row; ?>][position]">
                                <?php if ($module['position'] == 'content_top') { ?>
                                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                                <?php } else { ?>
                                <option value="content_top"><?php echo $text_content_top; ?></option>
                                <?php } ?>
                                <?php if ($module['position'] == 'content_bottom') { ?>
                                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                                <?php } else { ?>
                                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                                <?php } ?>
                                <?php if ($module['position'] == 'column_left') { ?>
                                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                                <?php } else { ?>
                                <option value="column_left"><?php echo $text_column_left; ?></option>
                                <?php } ?>
                                <?php if ($module['position'] == 'column_right') { ?>
                                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                                <?php } else { ?>
                                <option value="column_right"><?php echo $text_column_right; ?></option>
                                <?php } ?>
                            </select></td>
                        <td class="left"><select name="unfraud_module[<?php echo $module_row; ?>][status]">
                                <?php if ($module['status']) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                        <td class="right"><input type="text" name="unfraud_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
                        <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
                    </tr>
                    </tbody>
                    <?php $module_row++; ?>
                    <?php } ?>
                    <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
        <br>
        <div class="box">
            <div class="heading">
                <h1><img src="view/image/module.png" alt="" /> Unfraud Dashboard</h1>
            </div>
            <div class="content">
                <?php
                if($unfraud_email && $unfraud_password && $unfraud_apikey ){

                    $contents = json_decode(file_get_contents($unfraud_login_api_url.'&email='.$unfraud_email.'&password='.$unfraud_password),true);
                    if($contents["status"]=="logged"){
                        echo '<iframe src="'.$unfraud_login_url.'?e='.$unfraud_email.'&p='.$unfraud_password.'&t='.$unfraud_apikey.'" width="100%" height="1000" style="border:1px lightGray solid" frameborder="0"></iframe>';
                }
                else{
                echo $entry_credentials_error;
                }
                }
                else{
                echo $entry_configuration_error;
                }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        var module_row = <?php echo $module_row; ?>;

        function addModule() {
            html  = '<tbody id="module-row' + module_row + '">';
            html += '  <tr>';
            html += '    <td class="left"><input type="text" name="unfraud_module[' + module_row + '][limit]" value="5" size="1" /></td>';
            html += '    <td class="left"><input type="text" name="unfraud_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="unfraud_module[' + module_row + '][image_height]" value="80" size="3" /></td>';
            html += '    <td class="left"><select name="unfraud_module[' + module_row + '][layout_id]">';
        <?php foreach ($layouts as $layout) { ?>
                html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
            <?php } ?>
            html += '    </select></td>';
            html += '    <td class="left"><select name="unfraud_module[' + module_row + '][position]">';
            html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
            html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
            html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
            html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
            html += '    </select></td>';
            html += '    <td class="left"><select name="unfraud_module[' + module_row + '][status]">';
            html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
            html += '      <option value="0"><?php echo $text_disabled; ?></option>';
            html += '    </select></td>';
            html += '    <td class="right"><input type="text" name="unfraud_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
            html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
            html += '  </tr>';
            html += '</tbody>';

            $('#module tfoot').before(html);

            module_row++;
        }
        //--></script>

<?php break;
 }//end switch
?>
<?php echo $footer; ?>