<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeywordsSearchTweets extends FormRequest
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
        return [
            'keyword' => 'required',
            //'executed_at' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'keyword.required' => 'キーワードを入力して下さい。',
            //'executed_at.required' => '実行時刻を入力して下さい。',
        ];
    }
}
