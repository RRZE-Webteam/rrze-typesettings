jQuery(document).ready(function($) {
    // Render KaTeX in my CSS class elements
    $('.rrze-typesettings-block').each(function() {
        renderMathInElement(this);
    });

    // Render Prism
    Prism.highlightAll();
});
