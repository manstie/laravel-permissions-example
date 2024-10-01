<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyName = fake()->company;
        return [
            'name' => $companyName,
            'trading_name' => $companyName . ' ' . fake()->companySuffix,
            'abn' => fake()->numerify('## ### ### ###'),
            'acn' => fake()->numerify('### ### ###'),
            'invoice_email' => fake()->companyEmail,
            'phone' => fake()->phoneNumber,
            'fax' => null,
            'company_id' => null
        ];
    }
}
