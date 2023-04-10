<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string',
            'content' => 'required|string'
        ];

        switch ($this->method()) {
            case 'GET':
                $rules = [];
                if ($this->route()->uri === "api/posts/read" || $this->route()->uri === "api/public/posts/read") {
                    $rules['id'] = 'required|exists:posts,id';
                }
                break;
            case 'DELETE':
                $rules = [];
                $rules['id'] = 'required|exists:posts,id';
                break;
            case 'POST':
                $rules;
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [];
                $rules['id'] = 'required|exists:posts,id';
                break;
            default:
                $rules;
                break;
        }

        return $rules;
    }
}
