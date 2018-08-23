<?php

namespace Dhcd\Car\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CarRequest extends FormRequest
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
            case 'DELETE': {
                return [
                    'car_id' => 'required|numeric'
                ];
            }
            case 'POST': {
                $rules=[
                    'car_num' => 'required|numeric',
                    'car_bs' => 'required|max:255',
                    'note' => 'required'
                ];
                 $staffname = $request->input('staffname');
                if(!empty($staffname)){
                    foreach ($staffname as $key=>$item){
                        $rules['staffname.'.$key]='required|max:255';
                    }
                }
                return $rules;
            }
            case 'PUT':{
                $rules=[
                    'car_id' => 'required|numeric',
                    'car_num' => 'required|numeric',
                    'car_bs' => 'required|max:255',
                    'note' => 'required',
                ];
                 $staffname = $request->input('staffname');
                if(!empty($staffname)){
                    foreach ($staffname as $key=>$item){
                        $rules['staffname.'.$key]='required|max:255';
                    }
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
            'required'=>'Vui lòng nhập thông tin',
            'max'=>'Tên chương trình không dài quá 255 kí tự',
            "numeric" => "Phải là số"
        ];
    }
}