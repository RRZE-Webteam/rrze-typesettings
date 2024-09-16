import { useBlockProps, RichText, BlockControls, AlignmentToolbar } from '@wordpress/block-editor';
import { createElement as el, useRef } from '@wordpress/element';
import Prism from 'prismjs';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/themes/prism.css';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
import 'prismjs/components/prism-javascript'; 
import 'prismjs/components/prism-php'; 


const Edit = (props) => {
    const { attributes: { content, alignment }, setAttributes, className } = props;
    
    // Referenz für das Code-Element
    const codeRef = useRef(null);

    const onChangeContent = (newContent) => {
        setAttributes({ content: newContent });
    };

    const onChangeAlignment = (newAlignment) => {
        setAttributes({ alignment: newAlignment === undefined ? 'none' : newAlignment });
    };

    const onBlurHandler = () => {
        if (codeRef.current) {
            block.classList.add('line-numbers');  // activate line numbers
            Prism.highlightElement(codeRef.current);
        }
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
                    onChange: onChangeAlignment,
                })
            ),
            el(
                'pre',
                { style: { textAlign: alignment } },
                el(RichText, {
                    tagName: 'code',
                    className,
                    onChange: onChangeContent,
                    value: content,
                    placeholder: 'Enter your code here...',
                    ref: codeRef,
                    onBlur: onBlurHandler
                })
            )
        )
    );
};

export default Edit;
