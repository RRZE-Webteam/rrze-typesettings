import { RichText } from '@wordpress/block-editor';

const Save = ({ attributes }) => {
    return <RichText.Content tagName="p" value={attributes.content} className="rrze-typesettings-block" />;
}
export default Save;
