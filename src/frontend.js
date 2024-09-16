import Prism from 'prismjs';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/themes/prism.css';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';

import 'prismjs/components/prism-javascript'; 
import 'prismjs/components/prism-php'; 

// Prism.js initialisieren (für die Zeilennummern)
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre code').forEach((block) => {
        block.classList.add('line-numbers');  // activate line numbers
        Prism.highlightElement(block);
    });
});
