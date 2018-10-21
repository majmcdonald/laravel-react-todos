import React, { Component } from 'react';
import AddTodo from './AddTodo';
import { FaTrashAlt } from 'react-icons/fa';



/* Main Component */
class Main extends Component {

    constructor() {

        super();
        //Initialize the state in the constructor
        this.state = {
            todos: { data: [] },

        }
        this.handleAddTodo = this.handleAddTodo.bind(this);

    }

    componentDidMount() {
        fetch('/api/todo')
            .then(response => {
                return response.json();
            })
            .then(todos => {
                this.setState({ todos });
            });
    }

    updateStatus(todo)  {

        if(todo.status == 'done') {
            todo.status = 'new';
        } else {
            todo.status= 'done';
        }
        this.handleUpdateTodo(todo);
        return false;
    }

    handleUpdateTodo(todo) {
        fetch( 'api/todo/' + todo.id, {
            method:'put',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(todo)
        });
        this.forceUpdate();
    }

    handleDeleteTodo(todo) {
        fetch( 'api/todo/' + todo.id, {
            method:'delete',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                //remove this todo from the state
                let newTodos = this.state.todos.data.filter(function(item) {
                    return item !==todo;
                });
                this.setState({todos: {data: newTodos}})
            });
        this.forceUpdate();

    }

    handleAddTodo(todo) {
        fetch( 'api/todo/', {
            method:'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },

            body: JSON.stringify(todo)
        })
            .then(response => {
                return response.json();
            })
            .then( data => {

                this.setState((prevState)=> ({
                    todos: {data: prevState.todos.data.concat(data.data)},
                }))
            })

    }

    renderTodos() {
        return (
            <div>

                        <ul>
                            {this.state.todos.data.map(todo => {
                                return (

                                <li key={todo.id}>
                                    <input type="checkbox"
                                           todo-id={todo.id}
                                           checked={todo.status=='done'}
                                           onChange={this.updateStatus.bind(this, todo)}
                                    />
                                    {todo.name}
                                    <span onClick={this.handleDeleteTodo.bind(this,todo)}>
                                    <FaTrashAlt/>
                                    </span>
                                </li>
                                )})}
                        </ul>
            </div>
            );
    }

    render() {

        return (
            <div>
                <AddTodo onAdd={this.handleAddTodo} />
                <div >
                    <h1> ToDo List</h1>
                    { this.renderTodos() }

                </div>
            </div>

        );
    }
}

export default Main;

