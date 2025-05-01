import { useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
	const { dish } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<p className="menu-item-dish">{dish}</p>
		</div>
	);
}
