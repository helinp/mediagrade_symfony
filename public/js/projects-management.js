(function ($) {

	jQuery(document).ready(function() {

		var $wrapper = $('#assessment-grid');

		$wrapper.on('click', '.js-assessments-remove', function(e) {
			e.preventDefault();
			$(this).closest('.js-assessments-item')
			.fadeOut()
			.remove();
		});

		$('#assessment-table tfoot tr td').on('click', '.js-assessments-add', function(e) {
			e.preventDefault();
			// Get the data-prototype explained earlier
			var prototype = $wrapper.data('prototype');
			// get the new index
			var index = $wrapper.data('index');
			// Replace '__name__' in the prototype's HTML to
			// instead be a number based on how many items we have
			var newForm = prototype.replace(/__name__/g, index);
			// increase the index with one for the next item
			$wrapper.data('index', index + 1);
			// Display the form in the page before the "new" link
			$('#assessment-grid tr').last().after(newForm);
		});
	});

})(jQuery);
