<?php

namespace App\Http\Requests;

use App\Contracts\FormRules\DiscoverRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest implements DiscoverRules
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getBaseRule(): string
    {
        return request()->route()->getAction()['base_rule'] ?? "";
    }

    public function getRules(string $type): array
    {
        $model = (app()->make(request()->route()->getAction()['model']));
        return $model::rules()[$this->getBaseRule()][$type] ?? $model::rules()[$type];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return $this->getRules('POST');
    }
}
