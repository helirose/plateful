import Edit from "./edit";
import save from "./save";
import "./style.css";

console.log("Registering block:", "plateful/menu");

wp.blocks.registerBlockType("plateful/menu", {
	edit: Edit,
	save,
});
