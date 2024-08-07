import { useBlockProps } from '@wordpress/block-editor';
import { createElement as el } from '@wordpress/element';

const Save = (props) => {
    const { attributes: { content, alignment } } = props;
    return el(
        'pre',
        { style: { textAlign: alignment } },
        el('code', null, content)
    );
};

export default Save;