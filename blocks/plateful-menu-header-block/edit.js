import { TextControl } from "@wordpress/components";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const { title = "" } = attributes;

	return (
		<div {...useBlockProps()}>
			<TextControl
				label="title"
				value={title}
				onChange={(value) => setAttributes({ title: value })}
				required
			/>
		</div>
	);
}
