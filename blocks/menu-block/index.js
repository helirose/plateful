import Edit from "./edit";
import save from "./save";
import "./style.css";

wp.blocks.registerBlockType("plateful/menu", {
	title: "Menu",
	category: "text",
	icon: "list-view",
	supports: {
		html: false,
	},
	edit: Edit,
	save,
});
