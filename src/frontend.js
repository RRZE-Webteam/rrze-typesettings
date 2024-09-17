import Prism from 'prismjs';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-php';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/themes/prism.css';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
import 'prismjs/components/prism-javascript';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre code').forEach((block) => {
        const lineNumbersEnabled = block.getAttribute('data-linenumbers') === 'true';

        block.getAttributeNames().forEach(attrName => {
            const attrValue = block.getAttribute(attrName);
            console.log(`Attribut: ${attrName}, Wert: ${attrValue}`);
        });


        if (lineNumbersEnabled) {
            block.classList.add('line-numbers');
        }

        if (!block.className.includes('language-')) {
            block.classList.add('language-javascript');
        }

        if (Prism && typeof Prism.highlightElement === 'function') {
            Prism.highlightElement(block);
        }
    });
});
