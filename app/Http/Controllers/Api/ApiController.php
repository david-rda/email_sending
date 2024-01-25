<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BeneficiaryRequest;
use App\Models\Detail;
use App\Models\Emails;
use App\Models\Exhibition;
use App\Models\Organization;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FormExport;
use App\Exports\ExhibitionsExport;

class ApiController extends Controller
{
    /**
     * ბენეფიციარის მიერ დეტალების შევსების მეტოდი
     * @method POST
     * @return json
     */
    public function addDetail(Request $request, $id) {
        if(Exhibition::where("id", $id)->get()->count() == 0) {
            return response()->json([
                "error" => "ასეთი გამოფენა არ არსებობს."
            ], 422);
        }

        $this->validate($request, [
            "fullname" => "required|min:7|max:255",
            "position" => "required|max:255",
            "mobile" => "required|max:9|min:9",
            "email" => "required|email|max:255",
            "recomendation" => "required|min:5|max:500",
            "additional_info" => "required|max:500",
            "dynamicData.*.organization" => "required_if:organization,!=,null|max:255",
            "dynamicData.*.activity" => "required_if:activity,!=,null|max:255",
            "dynamicData.*.country" => "required_if:country,!=,null|max:255",
            "dynamicData.*.activityLevel" => "required_if:activityLevel,!=,null|max:255",
            "dynamicData.*.exportLocation" => "required_if:exportLocation,!=,null|max:255",
        ]);

        $details = Detail::updateOrCreate([
            "email" => $request->email
        ], [
            "exhibition_id" => $id,
            "name" => $request->fullname,
            "position" => $request->position,
            "mobile" => $request->mobile,
            "email" => $request->email,
            "recomendation" => $request->recomendation,
            "comment" => $request->additional_info,
        ]);

        if($request->dynamicData[0]["selected1"] != "0"):
            Organization::where("detail_id", $details->id)->delete();
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
        endif;

        try {
            $email = Emails::where("email", $request->email)->first();
            if($email == null) {
                return response()->json([
                    "errors" => [
                        "error" => [
                            "მიუთითეთ იმ ელ. ფოსტის მისამართი, რომელზეც გადმოგეგზავნათ შეტყობინება."
                        ]
                    ]
                ], 422);
            }else {
                $email->filled_status = 1;
                $email->save();
            }
        }catch(Exception $e) {
            return response()->json([
                "errors" => [
                    "error" => [
                        "დაფიქსირდა შეცდომა, გთხოვთ გადაამოწმოთ შევსებული მონაცემები."
                    ]
                ]
            ], 422);
        }

        if($details) {
            return response()->json([
                "success" => "დაემატა."
            ], 200);
        }else {
            return response()->json([
                "errors" => "ვერ დაემატა."
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

    /**
     * ბენეფიციარის მიერ შევსებული კონკრეტული დეტალების წამოღების მეთოდი
     * @method GET
     * @return json
     */
    public function getDetails($id = null) {
        if($id != null) return Detail::where("exhibition_id", $id)->get();

        return Detail::all();
    }

    /**
     * @method GET
     * 
     * განაცხადის ექსელის ჩამოტვირთვა
     */
    public function downloadExcel($id, $exhibition_id) {
        return Excel::download(new FormExport($id, $exhibition_id), "details.xlsx");
    }

    /**
     * @method GET
     * 
     * გამოფენების ექსელის ჩამოტვირთვა
     */
    public function downloadExcelExhibitions($exhibition_id) {
        return Excel::download(new ExhibitionsExport($exhibition_id), "data.xlsx");
    }
}
