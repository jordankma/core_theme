<?php

namespace Contest\Contest\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
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
                    'round_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'name' => 'required',
                    'domain' => 'required',
                    'image' => 'required',
                    'mysql_host' => 'required',
                    'mysql_port' => 'required',
                    'mysql_database' => 'required',
                    'mongodb_host' => 'required',
                    'mongodb_port' => 'required',
                    'mongodb_database' => 'required',
                ];
            }
            case 'PUT':{
                return [
                    'name' => 'required',
                    'domain' => 'required',
                    'image' => 'required',
                    'mysql_host' => 'required',
                    'mysql_port' => 'required',
                    'mysql_database' => 'required',
                    'mongodb_host' => 'required',
                    'mongodb_port' => 'required',
                    'mongodb_database' => 'required',
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }

    public function messages(){
        return [
            '*.required' => 'Không được để trống'
        ];
    }
}
