<div class="caldera-config-group">
	<label><?php esc_html_e( 'Environment', 'integrate-caldera-forms-salesforce' ); ?> </label>
	<div class="caldera-config-field">
		<select class="block-input field-config" name="{{_name}}[icfs_salesforce_environment]" id="icfs_salesforce_environment">
			<option value="1" {{#is context value="1"}}selected="selected"{{/is}}><?php esc_html_e( 'Production', 'integrate-caldera-forms-salesforce' ); ?></option>
            <option value="0" {{#is context value="0"}}selected="selected"{{/is}}><?php  esc_html_e( 'Sandbox', 'integrate-caldera-forms-salesforce' ); ?></option>
		</select>
	</div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Salesforce Organisation Id', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config required" id="icfs_salesforce_org_id" name="{{_name}}[icfs_salesforce_org_id]" value="{{icfs_salesforce_org_id}}" required="required">
        <div class="description">
            <?php echo __( 'Get your Production Organisation ID to <a href="https://help.salesforce.com/articleView?id=000325251&type=1&mode=1">Click Here</a>', 'integrate-caldera-forms-salesforce' ); ?>
            <br>
            <?php echo __( 'Get your Sandbox Organisation ID to <a href="https://help.salesforce.com/articleView?id=data_sandbox_create.htm&type=5">Click Here</a>', 'integrate-caldera-forms-salesforce' ); ?>
        </div>
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Salesforce Debugging Email', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="email" class="block-input field-config required" id="icfs_salesforce_debug_email" name="{{_name}}[icfs_salesforce_debug_email]" value="{{icfs_salesforce_debug_email}}" required="required">
        <div class="description">
            <?php esc_html_e( 'Provide a valid Email for debugging.', 'integrate-caldera-forms-salesforce' ) ?>
        </div>
    </div>
</div>

<div class="caldera-config-group">
	<label><?php esc_html_e( 'Salesforce Object', 'integrate-caldera-forms-salesforce' ); ?> </label>
	<div class="caldera-config-field">
		<select class="block-input field-config" name="{{_name}}[icfs_salesforce_obj]" id="icfs_salesforce_obj">
			<option value="Lead" {{#is context value="Lead"}}selected="selected"{{/is}}><?php esc_html_e( 'Lead', 'integrate-caldera-forms-salesforce' ); ?></option>
		</select>
	</div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'First Name', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind required" id="icfs_salesforce_first_name" name="{{_name}}[icfs_salesforce_first_name]" value="{{icfs_salesforce_first_name}}" required="required">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Last Name', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind" id="icfs_salesforce_last_name" name="{{_name}}[icfs_salesforce_last_name]" value="{{icfs_salesforce_last_name}}">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Your Email', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="email" class="block-input field-config magic-tag-enabled caldera-field-bind required" id="icfs_salesforce_email" name="{{_name}}[icfs_salesforce_email]" value="{{icfs_salesforce_email}}" required="required">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Company Name', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind" id="icfs_salesforce_company" name="{{_name}}[icfs_salesforce_company]" value="{{icfs_salesforce_company}}">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Title', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind" id="icfs_salesforce_title" name="{{_name}}[icfs_salesforce_title]" value="{{icfs_salesforce_title}}" >
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Mobile No', 'integrate-caldera-forms-salesforce' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind" id="icfs_salesforce_mobile" name="{{_name}}[icfs_salesforce_mobile]" value="{{icfs_salesforce_mobile}}">
    </div>
</div>

<div class="caldera-config-group">
    <div>To use dynampic field mapping for Caldera Salesforce Integration visit <a href="https://zetamatic.com/downloads/caldera-forms-salesforce-integration-pro/" target="_blank">here</a></div>
</div>
