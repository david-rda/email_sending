<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeneficiaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|min:7',
            'position' => 'required|max:255',
            'mobile' => 'required|max:9|min:9',
            'email' => 'required|email|max:255',
            // 'company_name' => 'required|string|max:255',
            // 'activity_name' => 'required|string|max:255',
            // 'country' => 'required|string|max:255',
            // 'stage_name' => 'required|string|max:255',
            // 'target_country_name' => 'required|string|max:255',
            // 'template_volume' => 'required_if:template_volume,!=,null|numeric',
            // 'template_price' => 'required_if:template_price,!=,null|numeric',
            // 'product_volume' => 'required_if:product_volume,!=,null|numeric',
            // 'product_price' => 'required_if:product_price,!=,null|numeric',
            "recomendation" => "required|min:5|max:500",
            "comment" => "required|min:5|max:500",
        ];
    }

    public function messages() {
        return [
            'name.required' => 'სახელი აუცილებელია.',
            'name.min' => 'სახელი, გვარი უნდა შედგებიდეს მინიმუმ 7 სიმბოლოსგან.',
            'name.max' => 'სახელი, გვარი უნდა შედგებიდეს მქსიმუმ 255 სიმბოლოსგან.',
            'position.required' => 'თანამდებობა აუცილებელია.',
            "email.required" => "ელ.ფოსტის მითითება აუცილებელია",
            "mobile.required" => "საკონტაქტო ტელეფონის მითითება აუცილებელია",
            "mobile.min" => "საკონტაქტო ტელეფონის ნომერი უნდა შედგებოდეს მინიმუმ 9 სიმბოლოსგან",
            "mobile.max" => "საკონტაქტო ტელეფონის ნომერი უნდა შედგებოდეს მაქსიმუმ 9 სიმბოლოსგან",
            "email.max" => "ელ.ფოსტა უნდა შედგებოდეს მაქსიმუმ 255 სიმბოლოსგან",
            // 'company_name.required' => 'კომპანია აუცილებელია.',
            // 'country.required' => 'ქვეყანა აუცილებელია.',
            // 'stage_name.required' => 'საქმიანი ურთიერთობის ეტაპი აუცილებელია.',
            // 'target_country_name.required' => 'საექსპორტო ქვეყნის მითითება აუცილებელია.',
            // 'activity_name.required' => 'საქმიანობის სფერო აუცილებელია.',
            // 'mobile.required' => 'საკონტაქტო ტელეფონის ნომერი აუცილებელია.',
            // 'mobile.min' => 'საკონტაქტო ტელეფონის ნომერი უნდა შედგებოდეს მინიმუმ 9 სიმბოლოსგან.',
            // 'mobile.max' => 'საკონტაქტო ტელეფონის ნომერი უნდა შედგებოდეს მაქსიმუმ 9 სიმბოლოსგან.',
            // 'template_volume.required' => 'ნიმუშის მოცულობა აუცილებელია',
            // 'template_price.required' => 'ნიმუსის ღირებულება აუცილებელია',
            // 'product_volume.required' => 'პროდუქტის მოცულობა აუცილებელია',
            // 'product_price.required' => 'პროდუქტის ღირებულება აუცილებელია',
            'comment.required' => 'კომენტარი აუცილებელია',
            'recomendation.required' => 'რეკომენდაცია აუცილებელია',
            'recomendation.min' => 'რეკომენდაცია უნდა შედგებოდეს მინიმუმ 5 სიმბოლოსგან',
            'comment.min' => 'კომენტარი უნდა შედგებოდეს მინიმუმ 5 სიმბოლოსგან',
            'recomendation.max' => 'კომენტარი უნდა შედგებოდეს მქსიმუმ 500 სიმბოლოსგან',
            'comment.max' => 'კომენტარი უნდა შედგებოდეს მქსიმუმ 500 სიმბოლოსგან',
        ];
    }
}
