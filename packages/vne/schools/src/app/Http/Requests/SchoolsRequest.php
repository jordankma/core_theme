<?php

namespace Vne\Schools\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SchoolsRequest extends FormRequest
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
//                    dd($request->all());
                    $rules = [
                        'schoolname' => 'required|max:255',
                        'level_id' => 'required|max:255|numeric',
                        'province_id' =>'required|numeric|not_in:0',
                        'district_id' =>'required|numeric|not_in:0'
                    ];
                    $memname = $request->input('memname');
                    if (!empty($memname)) {
                        foreach ($memname as $key => $item) {
                            $rules['memname.' . $key] = 'required|max:255';
                        }
                    }
                    $schoolphone = $request->input('schoolphone');
                    if (isset($schoolphone)) {
                        $rules['schoolphone'] = 'numeric';
                    }
                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        '_id' => 'required|numeric',
                        'schoolname' => 'required|max:255',
                        'level_id' => 'required|max:255|numeric',
                        'province_id' =>'required|numeric|not_in:0',
                        'district_id' =>'required|numeric|not_in:0',
                    ];
                    $memname = $request->input('memname');
                    if (!empty($memname)) {
                        foreach ($memname as $key => $item) {
                            $rules['memname.' . $key] = 'required|max:255';
                        }
                    }
                    $schoolphone = $request->input('schoolphone');
                    if (isset($schoolphone)) {
                        $rules['schoolphone'] = 'numeric';
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