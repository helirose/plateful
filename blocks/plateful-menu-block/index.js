import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

registerBlockType("plateful/menu", {
	edit: Edit,
	save: () => null,
});
