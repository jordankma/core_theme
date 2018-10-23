<?php

namespace Contest\Contestmanage\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
                    'number' => 'required|numeric|min:1',
                    'start_date' => 'required',
                    'question_pack' => 'required',
                    'end_date' => 'required',
                    'end_notify' => 'required',
                    'type' => 'required',
                    'round' => 'required',
                    'exam_repeat_time' => 'required|numeric'
                ];
            }
            case 'PUT':{
                return [
                    'name' => 'required',
                    'number' => 'required|numeric|min:1',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'end_notify' => 'required',
                    'type' => 'required',
                    'round' => 'required',
                    'exam_repeat_time' => 'required|numeric'
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
            'number.required'  => 'Thứ tự không được để trống',
            'round.required'  => 'Vòng thi không được để trống',
            'question_pack.required'  => 'Bộ đề không được để trống',
            'number.numeric'  => 'Thứ tự không hợp lệ',
            'number.min'  => 'Thứ tự không hợp lệ',
            'start_date.required'  => 'Ngày bắt đầu không được để trống',
            'end_date.required'  => 'Ngày kết thúc không được để trống',
            'end_notify.required'  => 'Thông báo không được để trống',
        ];
    }
}
