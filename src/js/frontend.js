import Prism from 'prismjs';
import 'prismjs/components/prism-markup-templating';  // Needed for some languages

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre[data-language]').forEach(async (block) => {
        const language = block.getAttribute('data-language');
        const theme = block.getAttribute('data-theme');
        const linenumbersEnabled = block.getAttribute('data-linenumbers') === 'true';

        // Dynamically import the theme based on the data-theme attribute
        if (theme === 'dark') {
            await import('prismjs/themes/prism-dark.min.css');
        } else if (theme === 'okaidia') {
            await import('prismjs/themes/prism-okaidia.min.css');
        } else if (theme === 'light') {
            await import('prismjs/themes/prism-solarizedlight.min.css');
        } else {
            await import('prismjs/themes/prism.min.css');  // Default theme
        }

        // Dynamically import the language based on the data-language attribute
        try {
            if (language === 'c') {
                await import('prismjs/components/prism-c');
            } else if (language === 'cpp') {
                await import('prismjs/components/prism-cpp');
            } else if (language === 'csharp') {
                await import('prismjs/components/prism-csharp');
            } else if (language === 'css') {
                await import('prismjs/components/prism-css');
            } else if (language === 'java') {
                await import('prismjs/components/prism-java');
            } else if (language === 'javascript') {
                await import('prismjs/components/prism-javascript');
            } else if (language === 'json') {
                await import('prismjs/components/prism-json');
            } else if (language === 'markup') {  // For HTML and XML
                await import('prismjs/components/prism-markup');
            } else if (language === 'perl') {
                await import('prismjs/components/prism-perl');
            } else if (language === 'php') {
                await import('prismjs/components/prism-php');
            } else if (language === 'python') {
                await import('prismjs/components/prism-python');
            } else if (language === 'jsx') {
                await import('prismjs/components/prism-jsx');
            } else if (language === 'regex') {
                await import('prismjs/components/prism-regex');
            } else if (language === 'sass') {
                await import('prismjs/components/prism-sass');
            } else if (language === 'sql') {
                await import('prismjs/components/prism-sql');
            } else {
                console.warn(`Language "${language}" is not supported. Falling back to JavaScript.`);
                await import('prismjs/components/prism-javascript');  // Fallback to JavaScript if the language is not supported
            }
        } catch (error) {
            console.error(`Error loading Prism component for "${language}":`, error);  // Log error if loading fails
        }
        
        block.classList.add(`language-${language}`);  // Add the language class to the block

        // Dynamically import the line-numbers plugin if needed
        if (linenumbersEnabled) {
            await import('prismjs/plugins/line-numbers/prism-line-numbers');  // Load line numbers plugin
            await import('prismjs/plugins/line-numbers/prism-line-numbers.css');  // Load line numbers CSS
            block.classList.add('line-numbers');  // Add the line-numbers class to the block
        }

        // Apply Prism.js syntax highlighting
        Prism.highlightAllUnder(block);
    });
});
