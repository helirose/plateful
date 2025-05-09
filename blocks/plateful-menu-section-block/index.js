import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

registerBlockType("plateful/menu-section", {
	edit: Edit,
	save: () => null,
});
