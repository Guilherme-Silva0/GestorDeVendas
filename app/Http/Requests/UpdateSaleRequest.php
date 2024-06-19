<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'products' => ['required', 'json'],
            'total' => ['required', 'regex:/^R\$\s?\d+(?:\.\d{3})*\,\d{2}$/'],
            'installments' => ['required', 'json'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $products = json_decode($this->input('products'), true);
                $installments = json_decode($this->input('installments'), true);
                $total = str_replace(['R$', ','], ['', '.'], $this->input('total'));

                if (!is_array($products) || empty($products)) {
                    $validator->errors()->add('products', 'Dados do produto inválidos');
                }

                if (!is_array($installments) || empty($installments)) {
                    $validator->errors()->add('installments', 'Dados das parcelas inválidos');
                } else {
                    $sum = 0;
                    $previousDate = null;

                    foreach ($installments as $installment) {
                        $sum += $installment['value'];

                        if ($installment['value'] > $total) {
                            $validator->errors()->add('installments', 'Parcela maior que o valor total.');
                        }

                        $currentDate = \Carbon\Carbon::parse($installment['due_date']);

                        if ($previousDate && $currentDate <= $previousDate) {
                            $validator->errors()->add('installments', 'Parcelas fora de ordem cronológica.');
                            break;
                        }

                        $previousDate = $currentDate;
                    }

                    if (number_format($sum, 2) != number_format($total, 2)) {
                        $validator->errors()->add('installments', 'A soma das parcelas não corresponde ao valor total.');
                    }
                }
            },
        ];
    }
}
