<?php

namespace Vne\Timeline\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimelineRequest extends FormRequest
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
                        'id' => 'required|numeric'
                    ];
                }
            case 'POST':
                {
                    $rules = [
                        'titles' => 'required|max:255',
                        'note'=> 'max:255'
                    ];
                    $data =  $request->time;
                    if(isset($data)){
                        list($start, $end ) = explode("-", $data);
                        $start = str_replace('/', '-', trim($start));
                        $end = str_replace('/', '-', trim($end));
                        $rules['starttime'.$start] ='require|date_format:"DD/M/YYYY"';
                        $rules['endtime'.$end] ='require|date_format:"DD/M/YYYY"|after:starttime.'.$start;
                    }
                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        'id'=> 'required|numeric',
                        'titles' => 'required|max:255',
                        'note'=> 'max:255'
                    ];
                    $data =  $request->time;
                    if(isset($data)){
                        list($start, $end ) = explode("-", $data);
                        $start = str_replace('/', '-', trim($start));
                        $end = str_replace('/', '-', trim($end));
                        $rules['starttime'.$start] ='date_format:"DD/M/YYYY"';
                        $rules['endtime'.$end] ='date_format:"DD/M/YYYY"|after:starttime.'.$start;
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
            'numeric' => 'Phải là số',
            'required' => 'Vui lòng nhập thông tin',
            'max' => 'Không dài quá 255 kí tự',
            'unique' => 'Không được trùng tên'
        ];
    }
}