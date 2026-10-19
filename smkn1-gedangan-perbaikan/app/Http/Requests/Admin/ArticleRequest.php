<?php

namespace App\Http\Requests\Admin;

use App\Rules\RichText;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        $creating = $this->isMethod('post');

        return [
            'title' => ['required', 'string', 'min:6', 'max:150'],
            'image' => [$creating ? 'required' : 'nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'text_content' => ['required', 'string', 'max:200000', new RichText(20)],
            'kategori_id' => ['required', 'array', 'min:1'],
            'kategori_id.*' => ['integer', 'exists:kategoris,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'judul',
            'image' => 'gambar',
            'text_content' => 'konten',
            'kategori_id' => 'kategori',
        ];
    }
}
