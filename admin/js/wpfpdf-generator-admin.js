(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
})( jQuery );
/* global wpforms_builder, wpf */

/**
 * Form Builder Panel Loader module.
 *
 * @since 1.8.6
 */

var WPForms = window.WPForms || {}; // eslint-disable-line no-var

WPForms.Admin = WPForms.Admin || {};
WPForms.Admin.Builder = WPForms.Admin.Builder || {};

WPForms.Admin.Builder.PdfGenerator = WPForms.Admin.Builder.PdfGenerator || ( function( document, window, $ ) {
	/**
	 * Elements holder.
	 *
	 * @since 1.8.6
	 *
	 * @type {Object}
	 */
	const el = {};

	/**
	 * Runtime variables.
	 *
	 * @since 1.8.6
	 *
	 * @type {Object}
	 */
	const vars = [];

	/**
	 * Public functions and properties.
	 *
	 * @since 1.8.6
	 *
	 * @type {Object}
	 */
	const app = {

		/**
		 * Start the engine.
		 *
		 * @since 1.8.6
		 */
		init() {
			$( app.ready );
		},

		/**
		 * DOM is fully loaded.
		 *
		 * @since 1.8.6
		 */
		ready() {
			app.setup();
			app.events();

			el.$builder.trigger( 'wpformsBuilderPdfGeneratorReady' );
			
		},

		/**
		 * Setup. Prepare some variables.
		 *
		 * @since 1.8.6
		 */
		setup() {
			// Cache DOM elements.
			el.$builder = $( '#wpforms-builder' );
			el.$form = $( '#wpforms-builder-form' );
			el.$panels = el.$builder.find( '.wpforms-panels' );
			// Init vars.
			vars.formID = el.$form.data( 'id' );
			
		},

		/**
		 * Bind events.
		 *
		 * @since 1.8.6
		 */
		events() {
			el.$builder.on('change','#wpforms-panel-field-settings-bvnode_wpf_pdf_template',app.loadTemplateFields)
			el.$builder.on('wpformsSettingsBlockAdded wpformsSettingsBlockCloned',app.get_pdf_notifications)
			el.$builder.on('wpformsSettingsBlockDeleted',app.remove_pdf_notifications)
			el.$builder.on('blur','.wpforms-builder-settings-block-name-edit input',app.change_pdf_notifications);
		},

		loadTemplateFields:function(e){
			var data = {
				template: e.target.value,
				action:  'wpforms_get_pdf_template_fields',
				form_id: vars.formID, // eslint-disable-line camelcase
				nonce: wpforms_builder.nonce,
			};
			$.post( wpforms_builder.ajax_url, data )
				.done( function( res ) {

					console.debug( res );
					$('.wpforms-fields').html(res);
				} )
				.fail( function( xhr, textStatus, e ) {

					console.debug( xhr.responseText || textStatus || '' );
				} );
		},
		get_pdf_notifications:function( event, $block ){
			if($block.data( 'blockType' ) !== 'notification'){
				return 0;
			}
			const id = $block.data('blockId');
			$('.wpforms-pdf-notifications .wpforms-panel-fields-group-inner').append(`

			<div id="wpforms-panel-field-settings-be_notifications${id}-wrap" class="wpforms-panel-field  wpforms-panel-field-toggle"><span class="wpforms-toggle-control ">
						
			<input type="checkbox" id="wpforms-panel-field-settings-be_notifications${id}" name="settings[be_notifications[${id}]]" class="" value="1" checked="checked">
			<label class="wpforms-toggle-control-icon" for="wpforms-panel-field-settings-be_notifications${id}"></label>
			<label for="wpforms-panel-field-settings-be_notifications${id}" class="wpforms-toggle-control-label">${$block.find( '.wpforms-builder-settings-block-header span' ).text()}</label>
			</span></div>

			`)
		},
		change_pdf_notifications:function(e){
			if ( ! $( e.relatedTarget ).hasClass( 'wpforms-builder-settings-block-edit' ) ) {
				var headerHolder = $(this).parents( '.wpforms-builder-settings-block-header' ),
				nameHolder   = headerHolder.find( '.wpforms-builder-settings-block-name' ),
				editHolder   = headerHolder.find( '.wpforms-builder-settings-block-name-edit' ),
				currentName  = editHolder.find( 'input' ).val().trim(),
				blockId     = $(this).closest( '.wpforms-builder-settings-block' ).data( 'block-id' );
				$('[for=wpforms-panel-field-settings-be_notifications'+blockId+']').text(currentName);
			}
		},
		remove_pdf_notifications:function(e,blockType,settingId){
			console.log(blockType,settingId);
			if(blockType !== 'notification'){
				return 0;
			}
			$('#wpforms-panel-field-settings-be_notifications'+settingId+'-wrap').remove();
			//get_pdf_notifications(e,$block);
			//add added 
		}
	};

	// Provide access to public functions/properties.
	return app;
}( document, window, jQuery ) );

// Initialize.
WPForms.Admin.Builder.PdfGenerator.init();
