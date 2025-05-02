import { SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";

export default function Edit({ attributes, setAttributes }) {
	const posts = useSelect(
		(select) =>
			select("core").getEntityRecords("postType", "plateful-menu-items", {
				per_page: -1,
			}),
		[],
	);

	if (!posts || !posts.length) {
		return <div>Loading...</div>;
	}

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
