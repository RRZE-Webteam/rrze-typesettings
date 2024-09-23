import { useBlockProps } from '@wordpress/block-editor';

const save = (props) => {
    const { attributes: { content, alignment, linenumbers, language, theme, copy } } = props;

    return (
        <div className="rrze-typesettings">
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
                <button type="button" className="btn" id="copyButton" name="copyButton" data-typesettings={ content }>
                    <img className="typesettings-copy-img" 
                        src="data:image/svg+xml,%3Csvg height='1024' width='896' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M128 768h256v64H128v-64z m320-384H128v64h320v-64z m128 192V448L384 640l192 192V704h320V576H576z m-288-64H128v64h160v-64zM128 704h160v-64H128v64z m576 64h64v128c-1 18-7 33-19 45s-27 18-45 19H64c-35 0-64-29-64-64V192c0-35 29-64 64-64h192C256 57 313 0 384 0s128 57 128 128h192c35 0 64 29 64 64v320h-64V320H64v576h640V768zM128 256h512c0-35-29-64-64-64h-64c-35 0-64-29-64-64s-29-64-64-64-64 29-64 64-29 64-64 64h-64c-35 0-64 29-64 64z' fill='%23000000' /%3E%3C/svg%3E" 
                        alt="Copy to clipboard" />
                    <span className="screen-reader-text">Copy to clipboard</span>
                </button>
            )}
            <span id="typesettings-tooltip" className="typesettings-tooltip">Copied to clipboard</span>
        </div>
    );
};

export default save;
