import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';
import block from './block.json';

registerBlockType(block.name, {
    ...block,
    edit: Edit,
    save: Save,
});
