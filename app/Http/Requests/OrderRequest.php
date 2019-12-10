<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'numeric'],
            'product_id' => ['required', 'numeric'],
            'product_price' => array('required', 'regex:/^\d*(\.\d{2})?$/'),
            'product_count' => ['required', 'numeric'],
            'order_sum' => array('required', 'regex:/^\d*(\.\d{2})?$/')
        ];
    }
}
