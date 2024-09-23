jQuery(document).ready(function ($) {
    // Attach event listener to the "Copy to clipboard" image
    $(document).on('click', '#copyButton', function (event) {
        event.preventDefault();
        var mycode = $(this).data('typesettings');
        copyToClipboard(mycode);
        event.stopPropagation(); // Stop event propagation
        return false; // Prevent the default action and propagation        
    });

    // Copy to Clipboard
    function copyToClipboard(mycode) {
        if (mycode) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(mycode)
                    .then(() => {
                        showTooltip('URL copied!');
                    })
                    .catch(err => {
                        console.error('Copy failed:', err);
                    });
            } else {
                // Fallback method for browsers that do not support Clipboard API
                const textArea = document.createElement('textarea');
                textArea.value = mycode;
                textArea.style.position = 'fixed'; // Ensure it's not visible in the viewport
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    showTooltip('Code copied!');
                } catch (err) {
                    console.error('Copy failed:', err);
                } finally {
                    document.body.removeChild(textArea); // Remove the textarea from the DOM
                }
            }
        }
    }

    function showTooltip(message) {
        const typesettings_tooltip = document.getElementById('typesettings-tooltip');
        typesettings_tooltip.textContent = message;
        typesettings_tooltip.style.display = 'inline-block';    
        setTimeout(() => {
            typesettings_tooltip.style.display = 'none';
        }, 2000); // Hide the typesettings-tooltip after 2 seconds
    }

});