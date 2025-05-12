import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

const Edit = () => {
	const blockProps = useBlockProps({
		className: "plateful-menu-block",
	});
	return (
		<div {...blockProps}>
			<InnerBlocks />
		</div>
	);
};

export default Edit;
