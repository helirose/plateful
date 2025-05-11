import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

console.log("Registering Plateful Menu SECTION Block...");
registerBlockType("plateful/menu-section", {
	edit: Edit,
	save: () => null,
});
