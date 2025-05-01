import { useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
	const { title } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<p className="menu-header-title">{title}</p>
		</div>
	);
}
