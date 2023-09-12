<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerServiceUpdateByManajer extends FormRequest
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
        $id = $this->route('id');
       
        return [
            'name' => 'sometimes',
            'email'=>['email', Rule::unique('users', 'email')->ignore($id)],
            'password' => 'sometimes',
            'no_hp' => 'sometimes',
        ];
    }

    public function getData()
    {
        $id = $this->route('id');
        $user = User::find($id);
        $data = $this->validated();
       if (!isset($data['password'])) {
        $data['password'] = $user->password; // atau $data['password'] = '';
    }
    $data['password'] = Hash::make($data['password']);

        return $data;
    }
}
