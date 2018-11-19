<?php

namespace Vne\Schools\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UnitRequest extends FormRequest
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
                    $rules = [
                        'unitname' => 'required|max:255',
                        'type' => 'numeric',
                        'parent' => 'numeric',
                        'unitname' => 'required|max:255',
                        'province_id' =>'required|numeric|not_in:0',
                        'district_id' =>'required|numeric|not_in:0'
                    ];
                    $memname = $request->input('memname');
                    if (!empty($memname)) {
                        foreach ($memname as $key => $item) {
                            $rules['memname.' . $key] = 'required|max:255';
                        }
                    }
                    $unitphone = $request->input('unitphone');
                    if (isset($unitphone)) {
                        $rules['unitphone'] = 'numeric';
                    }
                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        '_id' => 'required|numeric',
                        'unitname' => 'required|max:255',
                        'province_id' =>'required|numeric|not_in:0',
                        'district_id' =>'required|numeric|not_in:0'
                    ];
                    $memname = $request->input('memname');
                    if (!empty($memname)) {
                        foreach ($memname as $key => $item) {
                            $rules['memname.' . $key] = 'required|max:255';
                        }
                    }
                    $unitphone = $request->input('unitphone');
                    if (isset($unitphone)) {
                        $rules['unitphone'] = 'numeric';
                    }
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
            'not_in'=>'Phải chọn trường này',
            'numeric' => 'Phải là số',
            'required' => 'Vui lòng nhập thông tin',
            'max' => 'Tên chương trình không dài quá 255 kí tự',
            'unique' => 'Không được trùng tên'
        ];
    }
}