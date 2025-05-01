import Edit from "./edit";
import save from "./save";
import "./style.css";

wp.blocks.registerBlockType("plateful/menu-header", {
	edit: Edit,
	save,
});
