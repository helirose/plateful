import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
import Save from "./save";

registerBlockType("plateful/menu-item", {
	edit: Edit,
	save: Save,
});
