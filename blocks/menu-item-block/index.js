import Edit from "./edit";
import save from "./save";
import "./style.css";

wp.blocks.registerBlockType("plateful/menu-item", {
	title: "Menu Item",
	category: "text",
	parent: ["plateful/menu"],
	icon: "food",
	attributes: {
		selectedPost: {
			type: "number",
		},
	},
	edit: Edit,
	save,
});
