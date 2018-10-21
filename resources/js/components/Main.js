import React, { Component } from 'react';
import ReactDOM from 'react-dom';
 
/* An example React component */
class Main extends Component {
    render() {
        return (
            <div>
                <h3>React App</h3>
            </div>
        );
    }
}
 
export default Main;
 
/* The if statement is required so as to Render the component on pages that have a div with an ID of "root";  
*/
 
if (document.getElementById('app')) {
    ReactDOM.render(<Main />, document.getElementById('app'));
}
