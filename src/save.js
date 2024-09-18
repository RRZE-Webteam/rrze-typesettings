import { useBlockProps } from '@wordpress/block-editor';

const save = (props) => {
    const { attributes: { content, alignment, linenumber, language } } = props;

    return (
        <pre { ...useBlockProps.save({
            style: { textAlign: alignment },
            'data-language': language,
            'data-linenumbers': linenumber ? 'true' : 'false'
        }) }>
            <code>
                { content }
            </code>
        </pre>
    );
};

export default save;
