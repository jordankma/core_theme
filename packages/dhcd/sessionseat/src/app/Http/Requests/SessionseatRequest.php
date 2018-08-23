<?php

namespace Dhcd\Sessionseat\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SessionseatRequest extends FormRequest
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
                    'sessionseat_id' => 'required|numeric'
                ];
            }
            case 'POST': {
                return[
                    'sessionseat_name' => 'required|max:255',
                    'sessionseat_img' => 'required|max:255'
                    ];
            }
            case 'PUT':{
                return[
                    'sessionseat_id' => 'required|numeric',
                    'sessionseat_name' => 'required|max:255',
                    'sessionseat_img' => 'required|max:255'
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