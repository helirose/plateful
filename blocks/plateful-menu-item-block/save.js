import { useBlockProps } from "@wordpress/block-editor";

export default function Save({ attributes }) {
	const { selectedPost } = attributes;

	return (
		<div {...useBlockProps.save()}>
			<p>Post ID: {selectedPost}</p>
		</div>
	);
}
