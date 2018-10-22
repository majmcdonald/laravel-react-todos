import React, { Component } from 'react';
import AddTodo from './AddTodo';
import { FaTrashAlt } from 'react-icons/fa';
import classNames from 'classnames';




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
        fetch( 'api/todo', {
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
            <div >

                        <ul className="list-unstyled">
                            {this.state.todos.data.map(todo => {
                                let textClass = classNames("todoName", {
                                    'strikethrough': (todo.status=='done' )
                                });

                                return (

                                <li className="todo" key={todo.id}>
                                    <div className="todoItem">
                                            <input type="checkbox"
                                                   todo-id={todo.id}
                                                   checked={todo.status=='done'}
                                                   onChange={this.updateStatus.bind(this, todo)}
                                            />
                                        <span className={textClass}>{todo.name}</span>
                                    <span onClick={this.handleDeleteTodo.bind(this,todo)}>
                                    <FaTrashAlt/>
                                    </span>
                                    </div>
                                </li>
                                )})}
                        </ul>
            </div>
            );
    }

    render() {
        return (
            <div className="container">
                <div className={classNames("row", "mt-5")}>
                    <div className={classNames("col-md-12", " col-md-offset-6")}>
                        <AddTodo onAdd={this.handleAddTodo} />
                        <div >
                            <h1> ToDo List</h1>
                            { this.renderTodos() }

                        </div>
                    </div>
                </div>
            </div>

        );
    }
}

export default Main;

