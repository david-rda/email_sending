<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BeneficiaryRequest;
use App\Models\Detail;
use App\Models\Organization;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * ბენეფიციარის მიერ დეტალების შევსების მეტოდი
     * @method POST
     * @return json
     */
    public function addDetail(Request $request) {
        $this->validate($request, [
            "fullname" => "required",
            "position" => "required",
            "mobile" => "required",
            "email" => "required",
        ]);

        $details = Detail::updateOrCreate([
            "email" => $request->email
        ], [
            "exhibition_id" => 1,
            "name" => $request->fullname,
            "position" => $request->position,
            "mobile" => $request->mobile,
            "email" => $request->email,
            "recomendation" => $request->recomendation,
            "comment" => $request->additional_info,
        ]);

        foreach($request->dynamicData as $organizations) {
            Organization::insert([
                "detail_id" => $details->id,
                "company_name" => $organizations["organization"],
                "activity_name" => $organizations["activity"],
                "country" => $organizations["country"],
                "stage_name" => $organizations["activityLevel"],
                "target_country_name" => $organizations["exportLocation"],
                "template_volume" => isset($organizations["sent_example_volume"]) ? $organizations["sent_example_volume"] : "",
                "template_price" => isset($organizations["sent_example_price"]) ? $organizations["sent_example_price"] : "",
                "product_volume" => isset($organizations["sent_product_volume"]) ? $organizations["sent_product_volume"] : "",
                "product_price" =>  isset($organizations["sent_product_price"]) ? $organizations["sent_product_price"] : "",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }

        if($details) {
            return response()->json([
                "success" => "დაემატა."
            ], 200);
        }else {
            return response()->json([
                "error" => "ვერ დაემატა."
            ], 422);
        }
    }

    /**
     * ბენეფიციარის მიერ შევსებული კონკრეტული დეტალის წამოღების მეთოდი
     * @method GET
     * @return json
     */
    public function getDetail(int $id) {
        return Detail::find($id);
    }
}
