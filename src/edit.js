import { useBlockProps, BlockControls, InspectorControls, AlignmentToolbar } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { createElement as el, useRef, useEffect } from '@wordpress/element';
import Prism from 'prismjs';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/themes/prism.css';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';

import 'prismjs/components/prism-markup-templating';  
import 'prismjs/components/prism-php'; 
import 'prismjs/components/prism-javascript'; 
import 'prismjs/components/prism-markup';  // Für HTML

const Edit = (props) => {
    const { attributes: { content, alignment, linenumbers, theme, language }, setAttributes, className } = props;
    
    const codeRef = useRef(null);

    useEffect(() => {
        if (codeRef.current) {
            if (linenumbers) {
                codeRef.current.classList.add('line-numbers');
            } else {
                codeRef.current.classList.remove('line-numbers');
            }

            codeRef.current.classList.add(`language-${language}`);
            Prism.highlightElement(codeRef.current);
        }
    }, [content, linenumbers, theme, language]);

    const onChangeContent = (newContent) => {
        setAttributes({ content: newContent });
    };

    const onChangeLanguage = (newLanguage) => {
        setAttributes({ language: newLanguage });
    };

    const onChangeTheme = (newTheme) => {
        setAttributes({ theme: newTheme });
    };

    const onChangelinenumbers = (newlinenumbers) => {
        setAttributes({ linenumbers: newlinenumbers });
    };

    return (
        el(
            'div',
            useBlockProps(),
            el(
                BlockControls,
                { key: 'controls' },
                el(AlignmentToolbar, {
                    value: alignment,
                    onChange: (newAlignment) => setAttributes({ alignment: newAlignment === undefined ? 'none' : newAlignment }),
                })
            ),
            el(
                InspectorControls,
                { key: 'settings' },
                el(
                    PanelBody,
                    { title: 'Code Settings', initialOpen: true },
                    el(SelectControl, {
                        label: 'Language',
                        value: language,
                        options: [
                            { label: 'C', value: 'c' },
                            { label: 'C++', value: 'cpp' },
                            { label: 'C#', value: 'csharp' },
                            { label: 'CSS', value: 'css' },
                            { label: 'HTML', value: 'markup' },
                            { label: 'Java', value: 'java' },
                            { label: 'JavaScript', value: 'javascript' },
                            { label: 'JSON', value: 'json' },
                            { label: 'Perl', value: 'perl' },
                            { label: 'PHP', value: 'php' },
                            { label: 'Python', value: 'python' },
                            { label: 'React', value: 'jsx' },
                            { label: 'Regex', value: 'regex' },
                            { label: 'SASS', value: 'sass' },
                            { label: 'SQL', value: 'sql' },
                            { label: 'XML', value: 'markup' },
                        ],
                        onChange: onChangeLanguage,
                    }),
                    el(SelectControl, {
                        label: 'Theme',
                        value: theme,
                        options: [
                            { label: 'Default', value: 'default' },
                            { label: 'Light', value: 'light' },
                            { label: 'Dark', value: 'dark' },
                            { label: 'Okaidia', value: 'okaidia' },
                        ],
                        onChange: onChangeTheme,
                    }),
                    el(ToggleControl, {
                        label: 'Show line numbers',
                        checked: linenumbers,
                        onChange: onChangelinenumbers,
                    })
                )
            ),
            el(
                'pre',
                {
                    style: { textAlign: alignment },
                    className: theme !== 'default' ? `prism-${theme}` : '',
                    'data-linenumbers': linenumbers ? 'true' : 'false', 
                },
                el('textarea', {
                    className,
                    value: content,
                    placeholder: 'Enter your code here...',
                    onChange: (event) => onChangeContent(event.target.value),
                    'data-linenumbers': linenumbers ? 'true' : 'false', 
                    rows: 10,
                    style: { width: '100%', fontFamily: 'monospace', whiteSpace: 'pre', overflowWrap: 'normal', overflow: 'auto' },
                    ref: codeRef
                }),
            )
        )
    );
};

export default Edit;
