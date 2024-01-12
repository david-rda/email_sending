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
    public function index()
    {
        return Template::all();
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
            'exhibition_id' => $request->exhibition["id"],
            'datetime' => $request->datetime,
            'text' => $request->text,
            "link" => "http://localhost:8080/customer/" . $request->exhibition["id"]
        ]);

        foreach($request->emails as $emails) {
            Emails::insert([
                "template_id" => $template->id,
                "email" => $emails,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }

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
    public function show(string $id)
    {
        return Template::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Template::find($id)->delete();
    }
}
