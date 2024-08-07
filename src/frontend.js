import hljs from 'highlight.js/lib/core';
import 'highlight.js/styles/default.css';

import javascript from 'highlight.js/lib/languages/javascript';
import php from 'highlight.js/lib/languages/php';
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('php', php);

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });
});
