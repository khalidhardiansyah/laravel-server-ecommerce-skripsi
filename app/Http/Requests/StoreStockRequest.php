<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'stocks' => 'required|array',
            'stocks.*.size' => 'nullable|string',
            'stocks.*.stock' => 'required|integer',
            'stocks.*.products_id' => 'nullable|integer'
        ];
    }

    public function getData($idProduct)
    {
        $data = $this->validated();
        $data['products_id'] = $idProduct;
        return $data;
    }
}
