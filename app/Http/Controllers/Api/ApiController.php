<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BeneficiaryRequest;
use App\Models\Detail;

class ApiController extends Controller
{
    /**
     * ბენეფიციარის მიერ დეტალების შევსების მეტოდი
     * @method POST
     * @return json
     */
    public function addDetail(BeneficiaryRequest $request, int $id) {
        $validated = $request->validated();

        if($validated) {
            $details = Detail::updateOrCreate([
                "email" => $validated["email"]
            ], [
                "exhibition_id" => $id,
                "product_info_id" => 1,
                "name" => $validated["name"],
                "position" => $validated["position"],
                "mobile" => $validated["mobile"],
                "email" => $validated["email"],
                "activity" => !empty($request->activity) ? 1 : 0,
                "recomendation" => $validated["recomendation"],
                "comment" => $validated["comment"],
            ]);

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
