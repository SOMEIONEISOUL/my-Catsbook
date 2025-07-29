<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Пользователь должен быть авторизован для комментирования
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:1000', // Текст комментария обязательный, до 1000 символов
        ];
    }

    /**
     * Получение пользовательских сообщений об ошибках
     */
    public function messages(): array
    {
        return [
            'text.required' => 'Текст комментария обязателен для заполнения',
            'text.max' => 'Текст комментария не может превышать 1000 символов',
        ];
    }
}