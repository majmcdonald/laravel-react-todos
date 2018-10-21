<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Resources\TodoResource;
use App\Repositories\RepositoryInterface;
use App\Repositories\TodoRepository;


class TodoController extends Controller
{

    private $todoRepository;
    private $rules; 

    public function __construct(RepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
        $this->rules = [
        'name' => 'required|max:255',
        'due_date' => 'date|nullable',
        'status' => [Rule::in(['new', 'done'])], 
    ];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TodoResource::collection($this->todoRepository->findAll());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $todo = $this->todoRepository->create($request->all());
        return new TodoResource($todo);
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = $this->todoRepository->find($id);
        if($todo) { 
        return new TodoResource($todo);
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $this->todoRepository->find($id)->update($request->all());
        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todoRepository->find($id)->delete();
        return response()->json(null, 204);
    }
}
