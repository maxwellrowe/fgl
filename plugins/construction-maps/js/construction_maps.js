// Datatables for Past Notices
jQuery(document).ready(function() {
	var table = jQuery('#past-construction-table');
	if (!table.length || !jQuery.fn.DataTable) return;
	var isHomepage = table.attr('data-homepage') === 'true';
	table.DataTable({
		'ordering': false,
		'paging': !isHomepage,
		'searching': !isHomepage,
		'lengthChange': !isHomepage,
		'pagingType': 'simple',
		'lengthMenu': [ [5, 10, 25, -1], [5, 10, 25, "All"] ],
		'pageLength': 5,
		'stripeClasses': ['cm-odd','cm-even'],
		'bInfo': false,
		'oLanguage': {
			'sLengthMenu': '<strong>Show:</strong> _MENU_ notices'
		}
	});
});