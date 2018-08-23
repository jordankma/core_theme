<?php

namespace Dhcd\Seat\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SeatRequest extends FormRequest
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
                    'seat_id' => 'required|numeric'
                ];
            }
            case 'POST': {
//                print_r($request->all());die();
                return[
                    'doan_id' => 'required|numeric',
                    'sessionseat_id'=>'required|numeric',
                    'seat' => 'required|max:255',
                    'staffname'=> 'required'
                ];
            }
            case 'PUT':{
                return[
                    'seat_id' => 'required|numeric',
                    'doan' => 'required|max:255',
                    'sessionseat_id'=>'required|numeric',
                    'seat' => 'required|max:255',
                    'staffname'=> 'required'
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
            'required'=>'Vui lòng nhập thông tin',
            'max'=>'Tên chương trình không dài quá 255 kí tự',
        ];
    }
}