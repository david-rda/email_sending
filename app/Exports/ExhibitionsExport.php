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

class ExhibitionsExport implements FromArray, withHeadings, WithColumnWidths, WithStyles
{
    private $exhibition_id;

    public function __construct($exhibition_id) {
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
        $details = Detail::where("exhibition_id", $this->exhibition_id)->get();

        $data = [
            'გამოფენის დასახელება',
            'სახელი, გვარი',
            'მობილური',
            'თანამდებობა',
            'ელ. ფოსტა',
            'რეკომენდაცია',
            'დამატებითი ინფორმაცია',
        ];

        foreach($details as $key => $value) {
            foreach(Organization::where("detail_id", $value->id)->get() as $key1 => $value1) {
                array_push($data,
                    "საქმიანობის სფერო " . $key1 + 1,
                    "რომელ ქვეყანას წარმოადგენს " . $key1 + 1,
                    "ორგანიზაციის დასახელება " . $key1 + 1,
                    "საექსპორტო ქვეყანა " . $key1 + 1,
                    "რა ეტაპზეა საქმიანი ურთიერთობა? " . $key1 + 1,
                    "გაგზავნილი პროდუქციის მოცულობა " . $key1 + 1,
                    "გაგზავნილი პროდუქციის ფასი ლარებში " . $key1 + 1,
                    "გაგზავნილი ნიმუშის მოცულობა " . $key1 + 1,
                    "გაგზავნილი ნიმუშის ფასი ლარებში " . $key1 + 1,
                );
            }
        }

        return $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array() : array
    {
        $data = [];

        $detail = Detail::where("exhibition_id", $this->exhibition_id)->get();

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

            foreach(Organization::where("detail_id", $value->id)->get() as $key1 => $value1) {
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
