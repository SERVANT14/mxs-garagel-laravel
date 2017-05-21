<?php

namespace App\Services\Tracks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Track extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::guest()) {
            return false;
        }

        if ($this->method() === 'POST') {
            return Auth::user()->can('create', \App\Services\Tracks\Models\Track::class);
        }

        return Auth::user()->can('manage', $this->route('track'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'download_links' => 'array|required|min:1',
            'released_on' => 'date',
        ];
    }
}
