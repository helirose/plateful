import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
import Save from "./save";

registerBlockType("plateful/menu-header", {
	edit: Edit,
	save: Save,
});
