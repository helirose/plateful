import { TextControl } from "@wordpress/components";
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	return (
		<div className="plateful-menu-block">
			<InnerBlocks
				allowedBlocks={["plateful/menu-header", "plateful/menu-item"]}
			/>
		</div>
	);
}
