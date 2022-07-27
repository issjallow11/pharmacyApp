<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypesController extends BaseController
{
    protected $types = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Type $types)
    {
        $this->middleware('auth:api');
        $this->types = $types;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = $this->types->latest()->paginate(10);

        return $this->sendResponse($types, 'types list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $types = $this->types->pluck('name', 'id');

        return $this->sendResponse($types, 'Category list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $type= $this->types->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->sendResponse($type, 'Category Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $type = $this->types->findOrFail($id);

        $type->update($request->all());

        return $this->sendResponse($type, 'Category Information has been updated');
    }
}
