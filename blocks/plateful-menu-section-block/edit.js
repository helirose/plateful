import { TextControl } from "@wordpress/components";
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const { section_name = "" } = attributes;
	const blockProps = useBlockProps({
		className: "plateful-menu-section-block",
	});

	return (
		<div {...blockProps}>
			<TextControl
				label="Section name"
				value={section_name}
				onChange={(value) => setAttributes({ section_name: value })}
				required
			/>
			<InnerBlocks allowedBlocks={["plateful/menu-item"]} />
		</div>
	);
}
