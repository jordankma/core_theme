<?php

namespace Dhcd\Events\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
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
        $date = now();
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [
                    'role_id' => 'required|numeric'
                ];
            }
            case 'POST': {
                return [
                    'name' => 'required',
                    'date'=>'required'
                ];
            }
            case 'PUT':{
                return [
                    'event_id'=>'required|numeric',
                    'name' => 'required|min:5|max:191',
                    'date'=>'required|date_format:"d/m/Y"|after:' . date("d/m/Y", strtotime("yesterday"))
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
            'numeric'=>'Phải là số',
            'after_or_equal'=>'Vui lòng không nhập ngày trong quá khứ',
            'min'=>'Tên chương trình tối thiểu 5 kí tự trở lên',
            'max'=>'Tên chương trình không dài quá 255 kí tự'
        ];
    }
}
