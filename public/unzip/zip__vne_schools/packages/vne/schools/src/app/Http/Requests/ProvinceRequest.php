<?php

namespace Vne\Schools\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProvinceRequest extends FormRequest
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
                        '_id' => 'required|numeric'
                    ];
                }
            case 'POST':
                {
                    return
                    [
                        'province' => 'required|max:255|unique:mongodb.district',
                    ];
                }
            case 'PUT':
                {
                    return  [
                        '_id'=>'required|numeric',
                        'province' => 'required|max:255|unique:mongodb.district'
                    ];
                }
            case 'PATCH':
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng nhập thông tin',
            'numeric' => 'Phải là số',
            'max' => 'Tên chương trình không dài quá 255 kí tự',
            'unique' => 'Tên không được trùng'
        ];
    }
}