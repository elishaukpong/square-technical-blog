<?php

namespace App\Http\Requests;

use App\Models\Post;
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
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        if (null !== $this->get('_method', null)) {
            $method = $this->get('_method');
        }
        $this->offsetUnset('_method');

        switch ($method) {
            case 'GET':
                $this->rules = [];
                break;

            case 'POST':
                $this->rules = Post::rules;
                break;
            default:
                break;
        }

        return $this->rules;
    }
}
