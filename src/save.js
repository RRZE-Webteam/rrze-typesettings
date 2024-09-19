import { useBlockProps } from '@wordpress/block-editor';

const save = (props) => {
    const { attributes: { content, alignment, linenumbers, language, theme } } = props;

    return (
        <pre { ...useBlockProps.save({
            style: { textAlign: alignment },
            'data-language': language,
            'data-linenumbers': linenumbers ? 'true' : 'false',
            'data-theme': theme
        }) }>
            <code>
                { content }
            </code>
        </pre>
    );
};

export default save;
