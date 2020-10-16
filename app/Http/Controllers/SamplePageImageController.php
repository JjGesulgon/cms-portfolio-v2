<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SamplePageImageRepository;
use App\Http\Resources\SamplePageImageResource;

class SamplePageImageController extends Controller
{
    /**
     * Sample Page Image repository.
     *
     * @var App\Repositories\SamplePageImageRepository
     */
    protected $samplePageImage;

    /**
     * Create new instance of about controller.
     *
     * @param SamplePageImageRepository techStackItem TechStackItem repository
     */
    public function __construct(SamplePageImageRepository $samplePageImage)
    {
        $this->samplePageImage = $samplePageImage;
    }

    /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
    public function getList($id)
    {
        if (! $samplePageImage = $this->samplePageImage->getSamplePageImages($id)) {
            return response()->json([
                'message' => 'Resource does not exist'
            ], 400);
        }

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'samplePageImage' => $samplePageImage
        ], 200);
    }

    /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'image'         => 'required|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'message' => 'Validation failed',
              'errors'  => $validator->errors()
            ], 400);
        }

        if (! $this->samplePageImage->store($request)) {
            return response()->json([
                'message' => 'Failed to store resource'
            ], 500);
        }

        return response()->json([
          'message' => 'Resource successfully stored'
        ], 200);
    }

    /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
    public function destroy($id)
    {
        if (! $this->samplePageImage->findOrFail($id)->delete()) {
            return response()->json([
        'message' => 'Failed to delete resource'
      ], 400);
        }

        return response()->json([
      'message' => 'Resource successfully deleted'
    ], 200);
    }
}
