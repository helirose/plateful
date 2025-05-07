import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

registerBlockType("plateful/menu-item", {
	edit: Edit,
	save: () => null,
});
