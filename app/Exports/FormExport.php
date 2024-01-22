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
        $data = [];

        $organization = Organization::where("detail_id", $this->id)->get();
        $detail = Detail::find($this->id)->get();

        foreach($detail as $key => $value) {
            $data[] = [
                Exhibition::find($this->exhibition_id)->label,
                $value->name,
                $value->mobile,
                $value->position,
                $value->email,
                $value->recomendation,
                $value->comment,
            ];

            foreach($value->organizations as $key1 => $value1) {
                array_push($data[$key],
                    $value1->activity_name,
                    $value1->country,
                    $value1->company_name,
                    $value1->target_country_name,
                    $value1->stage_name,
                    (empty($value1->product_volume) ? "" : $value1->product_volume),
                    $value1->product_price,
                    (empty($value1->template_volume) ? "" : $value1->template_volume),
                    $value1->template_price,
                );
            }
        }


        return $data;
    }
}