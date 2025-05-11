import { TextControl } from "@wordpress/components";
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const { title = "" } = attributes;
	const blockProps = useBlockProps();

	return (
		<div {...blockProps}>
			<InnerBlocks allowedBlocks={["plateful/menu-item"]} />
		</div>
	);
}
