import React from "react";
import ReactDOM from "react-dom";
import Catalog from "./components/Catalog";


/**
 *
 * @returns {JSX.Element}
 * @constructor
 */
const App = () => {
    return <Catalog/>;
}

const rootElement = document.getElementById("catalog")

if (rootElement)
    ReactDOM.render(<App/>, rootElement);




