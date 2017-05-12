<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $segments = $this->segments();
        $id = intval(end($segments));

        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|unique:departments,name',
                    'description' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:departments,name,' . $id,
                    'description' => 'required'
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng điền tên.',
            'name.unique' => 'Tên này đã tồn tại.',
            'description.required' => 'Vui lòng điền mô tả.'
        ];
    }
}
