import Edit from "./edit";
import save from "./save";
import "./style.css";

console.log("Registering block:", "plateful/menu-item");

wp.blocks.registerBlockType("plateful/menu-item", {
	edit: Edit,
	save,
});
