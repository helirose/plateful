import { TextControl } from "@wordpress/components";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const { dish } = attributes;

	return (
		<div {...useBlockProps()}>
			<TextControl
				label="Dish name"
				value={dish}
				onChange={(value) => setAttributes({ dish: value })}
				required
			/>
		</div>
	);
}
