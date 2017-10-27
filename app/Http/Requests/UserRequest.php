<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email, ' . $id,
                'password' => 'confirmed'
            ];
        }
        default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng điền họ tên.',
            'email.unique' => 'Email này đã được sử dụng.',
            'email.email' => 'Email này không đúng định dạng.',
            'email.required' => 'Vui lòng điền email.',
            'password.required' => 'Vui lòng điền mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'khoa.require' => 'Vui lòng nhập khoa'
        ];
    }
}
