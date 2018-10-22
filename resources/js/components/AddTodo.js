import React, { Component } from 'react';

class AddTodo extends Component {

    constructor(props) {
        super(props);
        this.state = {
            newTodo: {
                name: '' // all that is required for a new todo, maybe add more fields after it is created
            }
        }
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleInput = this.handleInput.bind(this);

    }

    handleInput(key, e) {

        var state = Object.assign({}, this.state.newTodo);
        state[key] = e.target.value;
        this.setState({newTodo: state });
    }

    handleSubmit(e) {
        e.preventDefault();
        this.props.onAdd(this.state.newTodo);
        document.getElementById("addTodo").reset();
    }

    render() {


        return(
            <div>
                <div >
                    <form onSubmit={this.handleSubmit} id="addTodo">
                            <input type="text"  placeholder="What need to be Done?"  onChange={(e)=>this.handleInput('name',e)} className="form-control add-todo"/>
                        <input type="submit" value="Add" />
                    </form>
                </div>
            </div>)
    }
}

export default AddTodo;
