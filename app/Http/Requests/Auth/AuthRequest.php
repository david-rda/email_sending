<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            "email" => "required|email|max:255|min:7",
            "password" => "required|max:255|min:7"
        ];
    }

    /**
     * მოცემული მეტოდი პასუხისმგებელია ვალიდაციისას დაფიქსირებული კონკრეტული ტიპის შეტყობინებების ჩვენებაზე.
     * 
     * @return array
     */
    public function messages() : array {
        return [
            'email.required' => 'ელ.ფოსტის შეყვანა აუცილებელია.',
            'email.email' => 'შეიყვანეთ სწორი ფორმატის ელ.ფოსტა.',
            'email.min' => 'ელ.ფოსტა უნდა შედგებოდეს მინიმუმ 7 სიმბოლოსგან.',
            'email.max' => 'ელ.ფოსტა უნდა შედგებოდეს მაქსიმუმ 255 სიმბოლოსგან.',
            'password.max' => 'პაროლი უნდა შედგებოდეს მაქსიმუმ 255 სიმბოლოსგან.',
            'password.required' => 'პაროლის შეყვანა აუცილებელია.',
            'password.min' => 'პაროლი უნდა შედგებოდეს მინიმუმ 7 სიმბოლოსგან.',
        ];
    }
}
