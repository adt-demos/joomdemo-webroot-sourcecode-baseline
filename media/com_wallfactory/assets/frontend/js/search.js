jQuery(document).ready(function ($) {
    var query = $('div.wallfactory-view.view-search').data('query');

    $('div.post-text').mark(query);
});
