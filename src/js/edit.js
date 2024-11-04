import { useBlockProps, BlockControls, InspectorControls, AlignmentToolbar } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { createElement as el, useRef, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n'; // Import the __ function for translations
import Prism from '../../assets/js/prism.js';
import '../../assets/css/prism.css';

import 'prismjs/components/prism-markup-templating';  
import 'prismjs/components/prism-php'; 
import 'prismjs/components/prism-javascript'; 
import 'prismjs/components/prism-markup';  // For HTML

const Edit = (props) => {
    const { attributes: { content, alignment, linenumbers, theme, language, copy }, setAttributes, className } = props;
    
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

    const onToggleCopy = () => {
        setAttributes({ copy: !copy });
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
                    { title: __('Code Settings', 'rrze-typesettings'), initialOpen: true },
                    el(SelectControl, {
                        label: __('Language', 'rrze-typesettings'),
                        value: language,
                        options: [
                            { label: __('C', 'rrze-typesettings'), value: 'c' },
                            { label: __('C++', 'rrze-typesettings'), value: 'cpp' },
                            { label: __('C#', 'rrze-typesettings'), value: 'csharp' },
                            { label: __('CSS', 'rrze-typesettings'), value: 'css' },
                            { label: __('HTML', 'rrze-typesettings'), value: 'markup' },
                            { label: __('Java', 'rrze-typesettings'), value: 'java' },
                            { label: __('JavaScript', 'rrze-typesettings'), value: 'javascript' },
                            { label: __('JSON', 'rrze-typesettings'), value: 'json' },
                            { label: __('PHP', 'rrze-typesettings'), value: 'php' },
                            { label: __('Python', 'rrze-typesettings'), value: 'python' },
                            { label: __('React', 'rrze-typesettings'), value: 'jsx' },
                            { label: __('SQL', 'rrze-typesettings'), value: 'sql' },
                            { label: __('XML', 'rrze-typesettings'), value: 'markup' },
                        ],
                        onChange: onChangeLanguage,
                    }),
                    el(SelectControl, {
                        label: __('Theme', 'rrze-typesettings'), // Translated label
                        value: theme,
                        options: [
                            { label: __('Default', 'rrze-typesettings'), value: 'default' },
                            { label: __('Light', 'rrze-typesettings'), value: 'light' },
                            { label: __('Dark', 'rrze-typesettings'), value: 'dark' },
                            { label: __('Okaidia', 'rrze-typesettings'), value: 'okaidia' },
                        ],
                        onChange: onChangeTheme,
                    }),
                    el(ToggleControl, {
                        label: __('Show line numbers', 'rrze-typesettings'), // Translated label
                        checked: linenumbers,
                        onChange: onChangelinenumbers,
                    }),
                    el(ToggleControl, {
                        label: __('Enable Copy to Clipboard', 'rrze-typesettings'), // Translated label
                        checked: copy,
                        onChange: onToggleCopy,
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
                    placeholder: __('Enter your code here...', 'rrze-typesettings'), // Translated placeholder
                    onChange: (event) => onChangeContent(event.target.value),
                    'data-linenumbers': linenumbers ? 'true' : 'false', 
                    rows: 10,
                    style: { width: '100%', fontFamily: 'monospace', whiteSpace: 'pre', overflowWrap: 'normal', overflow: 'auto' },
                    ref: codeRef
                })
            )
        )
    );
};

export default Edit;
