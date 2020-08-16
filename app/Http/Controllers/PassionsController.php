<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PassionRepository;
use App\Http\Resources\PassionResource;

class PassionsController extends Controller
{
    /**
     * Passion repository.
     *
     * @var App\Repositories\PassionRepository
     */
    protected $passion;

    /**
     * Create new instance of about controller.
     *
     * @param PassionRepository passion Passion repository
     */
    public function __construct(PassionRepository $passion)
    {
        $this->passion = $passion;
    }

    /**
     * Display the first resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passion = PassionResource::collection(
            $this->passion->getPassions()
        );

        if (! $passion) {
            return response()->json([
            'message' => 'Failed to retrieve resource'
        ], 400);
        }

        return $passion;
    }

    /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
    public function show($id)
    {
        if (! $passion = $this->passion->findOrFail($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'passion' => $passion
        ], 200);
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
        $validator = Validator::make($request->all(), [
          'name'          => 'required',
          'description'   => 'required',
          'image'         => 'max:2000',
        ]);

            if ($validator->fails()) {
                return response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors()
          ], 400);
            }

            if (! $this->passion->update($request, $id)) {
                return response()->json([
            'message' => 'Failed to update resource'
          ], 500);
            }

            return response()->json([
          'message' => 'Resource successfully updated'
        ], 200);
    }
}
