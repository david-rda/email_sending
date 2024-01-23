<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Detail;
use App\Models\Exhibition;
use App\Models\Organization;

class FormExport implements FromArray, withHeadings, WithColumnWidths, WithStyles
{
    private $id;
    private $exhibition_id;

    public function __construct($id, $exhibition_id) {
        $this->id = $id;
        $this->exhibition_id = $exhibition_id;
    }

    public function styles(Worksheet $sheet) {
        return [
            1 => [
                'font' => ['bold' => true],
                'height => 38'
            ],
        ];
    }

    public function columnWidths(): array {
        return [
            'A' => 40,
            'B' => 40,
            'C' => 40,
            'D' => 40,
            'E' => 40,
            'F' => 40,
            'G' => 40,
            'H' => 40,
            'I' => 40,
            'J' => 40,
            'K' => 40,
            'L' => 40,
            'M' => 40,
            'N' => 40,
            'O' => 40,
            'P' => 40,
            'Q' => 40,
            'R' => 40,
            'S' => 40,
            'T' => 40,
            'U' => 40,
            'V' => 40,
            'W' => 40,
            'X' => 40,
            'Y' => 40,
            'Z' => 40
        ];
    }

    public function headings(): array
    {
        $organization = Organization::where("detail_id", $this->id)->get();

        $data = [
            'გამოფენის დასახელება',
            'სახელი, გვარი',
            'მობილური',
            'თანამდებობა',
            'ელ. ფოსტა',
            'რეკომენდაცია',
            'დამატებითი ინფორმაცია',
        ];

        foreach($organization as $key => $value) {
            array_push($data,
                "საქმიანობის სფერო " . $key + 1,
                "რომელ ქვეყანას წარმოადგენს " . $key + 1,
                "ორგანიზაციის დასახელება " . $key + 1,
                "საექსპორტო ქვეყანა " . $key + 1,
                "რა ეტაპზეა საქმიანი ურთიერთობა? " . $key + 1,
                "გაგზავნილი პროდუქციის მოცულობა " . $key + 1,
                "გაგზავნილი პროდუქციის ფასი ლარებში " . $key + 1,
                "გაგზავნილი ნიმუშის მოცულობა " . $key + 1,
                "გაგზავნილი ნიმუშის ფასი ლარებში " . $key + 1,
            );
        }

        return $data;
    }

    public function array(): array
    {
        $organization = Organization::where("detail_id", $this->id)->get();
        $detail = Detail::find($this->id);

        $data = [
            Exhibition::find($this->exhibition_id)->label,
            $detail->name,
            $detail->mobile,
            $detail->position,
            $detail->email,
            $detail->recomendation,
            $detail->comment,
        ];

        foreach($organization as $key1 => $value) {
            array_push($data,
                $value["activity_name"],
                $value["country"],
                $value["company_name"],
                $value["target_country_name"],
                $value["stage_name"],
                (empty($value["product_volume"]) ? "" : $value["product_volume"]),
                $value["product_price"],
                (empty($value["template_volume"]) ? "" : $value["template_volume"]),
                $value["template_price"],
            );
        }

        return [$data];
    }
}