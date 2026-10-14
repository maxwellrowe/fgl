// Datatables for Past Notices
jQuery(document).ready(function() {
	jQuery('#past-construction-table').DataTable({
		'ordering': false,
		'paging': true,
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