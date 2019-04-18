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
                    'topic_point_condition' => 'required|numeric|min:0',
                    'topic_exam_repeat_condition' => 'required|numeric|min:0',
                    'topic_point_method' => 'required',
                    'exam_repeat_time' => 'required|numeric|min:0',
                    'exam_repeat_time_wait' => 'required|numeric|min:0',
                    'total_time_limit' => 'required|numeric|min:0',
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
                    'topic_point_condition' => 'required|numeric|min:0',
                    'topic_exam_repeat_condition' => 'required|numeric|min:0',
                    'topic_point_method' => 'required',
                    'exam_repeat_time' => 'required|numeric|min:0',
                    'exam_repeat_time_wait' => 'required|numeric|min:0',
                    'total_time_limit' => 'required|numeric|min:0'
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
            'number.numeric'  => 'Thứ tự phải là số',
            'number.min'  => 'Thứ tự phải lớn hơn 0',
            'start_date.required'  => 'Ngày bắt đầu không được để trống',
            'end_date.required'  => 'Ngày kết thúc không được để trống',
            'end_notify.required'  => 'Thông báo không được để trống',
            'topic_condition.required'  => 'Hãy chọn điều kiện màn thi',
            'topic_point_method.required'  => 'Hãy chọn cách tính điểm màn thi',
            'exam_repeat_time.required'  => 'Số lần thi không được để trống',
            'exam_repeat_time_wait.required'  => 'Thời gian chờ không được để trống',
            'total_time_limit.required'  => 'Tổng thời gian không được để trống',
            'exam_repeat_time.numeric'  => 'Số lần thi phải là số',
            'exam_repeat_time_wait.numeric'  => 'Thời gian chờ phải là số',
            'total_time_limit.numeric'  => 'Tổng thời gian phải là số',
            'exam_repeat_time.min'  => 'Số lần thi phải lớn hơn 0',
            'exam_repeat_time_wait.min'  => 'Thời gian chờ phải >= 0',
            'total_time_limit.min'  => 'Tổng thời gian phải  >= 0',
        ];
    }
}
