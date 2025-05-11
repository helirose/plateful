import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

console.log("Registering Plateful Menu ITEM Block...");
registerBlockType("plateful/menu-item", {
	edit: Edit,
	save: () => null,
});
