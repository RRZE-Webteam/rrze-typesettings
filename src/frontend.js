import Prism from 'prismjs';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-php';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/themes/prism.css';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
import 'prismjs/components/prism-javascript';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre[data-language]').forEach((block) => {
        const language = block.getAttribute('data-language');
        const lineNumbersEnabled = block.getAttribute('data-linenumbers') === 'true';

        console.log(`Language: ${language}, Line numbers: ${lineNumbersEnabled}`);

        block.classList.add(`language-${language}`);

        if (lineNumbersEnabled) {
            block.classList.add('line-numbers');
        }

        Prism.highlightAllUnder(block);
    });
});
