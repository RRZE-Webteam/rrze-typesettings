import { useBlockProps } from '@wordpress/block-editor';

const save = (props) => {
    const { attributes: { content, alignment, linenumbers, language, theme, copy } } = props;

    return (
        <div>
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
            { copy && (
                <button type="button" className="btn" id="copyButton" data-typesettings={ content }>
                    Copy to clipboard
                </button>
            )}
        </div>
    );
};

export default save;
