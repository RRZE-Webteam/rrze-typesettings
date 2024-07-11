import { RichText } from '@wordpress/block-editor';

const Edit = ({ attributes, setAttributes }) => {
    return (
        <RichText
            tagName="p"
            value={attributes.content}
            onChange={(content) => setAttributes({ content })}
            className="rrze-typesettings-block"
        />
    );
};

export default Edit;
