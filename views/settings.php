<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=cl_geoplugin'.AMP.'method=settings')?>
<table class="mainTable" border="0" cellspacing="0" cellpadding="0">
	<tr><th colspan="2">Global Settings</th></tr>
	<tr>
		<td><label for="short_name">License</label><div class="subtext">License provided by ExpressionEngine DFW.</div></td>
		<td><input type="text" name="settings[license]" id="redirect_uri" value="<?php echo $settings['license'] ?>" /></td>
	</tr>
</table>

<div class="tableFooter">
	<div class="tableSubmit">
		<?php echo form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'submit'));?>
	</div>
</div>	
<?php echo form_close()?>