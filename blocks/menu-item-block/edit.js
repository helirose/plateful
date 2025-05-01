import { SelectControl, TextControl } from "@wordpress/components";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const posts = useSelect(
		(select) =>
			select("core").getEntityRecords("postType", "menu-items", {
				per_page: -1,
			}),
		[],
	);

	if (!posts) return "Loading...";

	const options = posts.map((post) => ({
		label: post.title.rendered,
		value: post.id,
	}));

	return (
		<SelectControl
			label="Select Menu Item"
			value={attributes.selectedPost}
			options={[{ label: "Select a dish", value: 0 }, ...options]}
			onChange={(value) => setAttributes({ selectedPost: parseInt(value) })}
		/>
	);
}
