<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ExpFilenames = [
            '20130922',
            '20131006',
            '20131110',
            '20131229',
            '20140126',
            '20140209',
            '20140316',
            '20140406',
            '20140518',
            '20140615',
            '20140713',
            '20140713a',
            '20140831',
            '20141123',
            '20141229',
            '20150215',
            '20150308',
            '20150419',
            '20150510',
            '20150927',
            '20151011',
            '20151227',
            '20160417',
            '20160508',
        ];
        return [
            //
            'filename' => $ExpFilenames[array_rand($ExpFilenames)],

        ];
    }
}
