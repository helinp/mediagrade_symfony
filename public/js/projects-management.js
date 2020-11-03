/**
 *
 *  Typeahead
 *
 **/

/* CRITERION */
var autocompleteUrl = $(".typeahead_criterion").data("autocomplete-url");
var typeaheadOptionCriterionB = {
  limit: 6,
  async: true,
  displayKey: "name",
  source: function (query, processSync, processAsync) {
    return $.ajax({
      url: autocompleteUrl,
      type: "GET",
      data: { query: query },
      dataType: "json",

      success: function (json) {
        return processAsync(json);
      },
    });
  },
};

var typeaheadOptionCriterionA = {
  hint: true,
  highlight: true,
  minLength: 2,
};

/* INDICATOR */
var autocompleteUrlIndicator = $(".typeahead_indicator").data(
  "autocomplete-url"
);
var typeaheadOptionsIndicatorA = {
  hint: true,
  highlight: true,
  minLength: 2,
};

var typeaheadOptionsIndicatorB = {
  limit: 6,
  async: true,
  displayKey: "indicator",
  source: function (query, processSync, processAsync) {
    return $.ajax({
      url: autocompleteUrlIndicator,
      type: "GET",
      data: { query: query },
      dataType: "json",

      success: function (json) {
        return processAsync(json);
      },
    });
  },
};

(function ($) {
  jQuery(document).ready(function () {
    var $wrapper = $("#assessment-grid");

    $wrapper.on("click", ".js-assessments-remove", function (e) {
      e.preventDefault();
      $(this).closest(".js-assessments-item").fadeOut().remove();
    });

    $("#assessment-table tfoot tr td").on(
      "click",
      ".js-assessments-add",
      function (e) {
        e.preventDefault();
        // Get the data-prototype explained earlier
        var prototype = $wrapper.data("prototype");
        // get the new index
        var index = $wrapper.data("index");
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);
        // increase the index with one for the next item
        $wrapper.data("index", index + 1);
        // Display the form in the page before the "new" link
        $("#assessment-grid tr").last().after(newForm);

        // TYPEAHEAD
        $(".typeahead_criterion").typeahead("destroy");
        $(".typeahead_criterion").typeahead(typeaheadOptionCriterionA, typeaheadOptionCriterionB);

        $(".typeahead_indicator").typeahead("destroy");
        $(".typeahead_indicator").typeahead(typeaheadOptionsIndicatorA, typeaheadOptionsIndicatorB);
      }
    );
  });
})(jQuery);

$(".typeahead_criterion").typeahead(typeaheadOptionCriterionA, typeaheadOptionCriterionB);
$(".typeahead_indicator").typeahead(typeaheadOptionsIndicatorA, typeaheadOptionsIndicatorB);
