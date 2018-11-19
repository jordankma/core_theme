<?php

namespace Vne\Schools\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class NationsRequest extends FormRequest
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
     * @return array
     */
    public function rules(Request $request)
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [
                        'id' => 'required|numeric'
                    ];
                }
            case 'POST':
                {
                    $rules = [
                        'nation' => 'required|max:255',

                    ];
                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        'id' => 'required|numeric',
                        'nation' => 'required|max:255',
                    ];
                    return $rules;
                }
            case 'PATCH':
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'numeric' => 'Phải là số',
            'required' => 'Vui lòng nhập thông tin',
            'max' => 'Tên chương trình không dài quá 255 kí tự'
        ];
    }
}