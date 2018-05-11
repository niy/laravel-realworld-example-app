<?php

namespace App\Http\Requests\Api;

class UpdateArticleVideo extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $article = $this->route('article');

        return $article->user_id == auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'video' => 'file|required|mimetypes:video/avi,video/mp4'
        ];
    }
}
