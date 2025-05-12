import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit.js";
import metadata from "./block.json";

registerBlockType(metadata, {
	edit: Edit,
	save: () => null,
});
