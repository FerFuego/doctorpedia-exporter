
/**
 * 
 * @returns Returns manual import
 */
function Doctorpedia_exporter_run () {

    event.preventDefault();

    var formData = new FormData();
        formData.append('action', 'run_exporter');

    jQuery.ajax({
        cache: false,
        url: bms_vars.ajaxurl,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            jQuery('#response_import').html( '<p class="text-info">Creating Report...</p>' );
        },
        success: function ( response ) {
            jQuery('#response_import').html( '<p class="text-success">Report Complete!</p>' );
            jQuery('<a id="someID" target="_blank" href="'+response.data+'" download>Download</a>').appendTo('#response_import');
        }
    });
    return false;
}
