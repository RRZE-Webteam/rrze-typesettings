import Prism from '../../assets/js/prism.js';
import 'prismjs/components/prism-markup-templating';  // Needed for some languages

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre[data-language]').forEach(async (block) => {
        const language = block.getAttribute('data-language');

        console.log(`Loading Prism.js for ${language}...`);

        const theme = block.getAttribute('data-theme');
        const linenumbersEnabled = block.getAttribute('data-linenumbers') === 'true';

        // Dynamically import the theme based on the data-theme attribute
        if (theme === 'dark') {
            await import('../../assets/css/prism-dark.css');
        } else if (theme === 'okaidia') {
            await import('../../assets/css/prism-okaidia.css');
        } else if (theme === 'light') {
            await import('../../assets/css/prism-solarizedlight.css');
        } else {
            await import('../../assets/css/prism.css');  // Default theme
        }
        
        block.classList.add(`language-${language}`);  // Add the language class to the block

        // Dynamically import the line-numbers plugin if needed
        if (linenumbersEnabled) {
            block.classList.add('line-numbers');  // Add the line-numbers class to the block
        }

        // Apply Prism.js syntax highlighting
        Prism.highlightAllUnder(block);
    });
});
