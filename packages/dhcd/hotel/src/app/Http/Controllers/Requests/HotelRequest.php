<?php

namespace Dhcd\Hotel\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class HotelRequest extends FormRequest
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
                    'hotel_id' => 'required|numeric'
                ];
            }
            case 'POST': {
                $rules=[
                    'hotel' => 'required|max:191',
                    'address' => 'required|max:191'
                ];
                $staffname = $request->input('staffname');
                if(!empty($staffname)){
                    foreach ($staffname as $key=>$item){
                        $rules['staffname.'.$key]='required|max:191';
                    }
                }
                return $rules;
            }
            case 'PUT':{
                $rules=[
                    'hotel_id' => 'required|numeric',
                    'hotel' => 'required|max:255',
                    'address' => 'required|max:255'
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
        ];
    }
}