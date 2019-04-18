<?php

namespace Contest\Contestmanage\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAccountRequest extends FormRequest
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
    public function rules()
    {

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [
                    'topic_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'name' => 'required',
                    'password' => 'required',
                    'email' => 'required|max:200,|unique:mysql_core.adtech_core_users'
                ];
            }
            case 'PUT':{
                return [
                    'name' => 'required',
                    'password' => 'required',
                    'number' => 'required|numeric|min:1',
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }

    public function messages(){
        return [
            'name.required' => 'Tên không được để trống',
            'number.required'  => 'Thứ tự không được để trống'
        ];
    }
}
