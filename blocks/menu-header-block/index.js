import Edit from "./edit";
import save from "./save";
import "./style.css";

console.log("Registering block:", "plateful/menu-header");

wp.blocks.registerBlockType("plateful/menu-header", {
	edit: Edit,
	save,
});
