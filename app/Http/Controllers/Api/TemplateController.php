<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Emails;
use Carbon\Carbon;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $exhibition_id)
    {
        return Template::where("exhibition_id", $exhibition_id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'exhibition' => 'required',
            'datetime' => 'required',
            'text' => 'required',
        ]);

        $template = Template::create([
            'exhibition_id' => $request->exhibition,
            'datetime' => $request->datetime,
            'text' => $request->text,
            "link" => "http://localhost:8080/customer/" . $request->exhibition
        ]);

        if($template) {
            return response()->json([
                'message' => 'ნიმუში შეინახა წარმატებით.',
            ], 200);
        }else {
            return response()->json([
                'error' => 'ნიმუში ვერ შეინახა.',
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $exhibition_id)
    {
        return Template::where("exhibition_id", $exhibition_id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $exhibition_id)
    {
        $this->validate($request, [
            "datetime" => "required",
            "text" => "required"
        ]);

        try {
            $template = Template::where("exhibition_id", $exhibition_id)->first();
            $template->datetime = $request->datetime;
            $template->text = $request->text;
            $template->save();
            
            return response()->json([
                "success" => "ნიმუში დაემატა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "error" => "ნიმუში ვერ დაემატა"
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Template::find($id)->delete();
    }
}
