<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::factory()->count(56)->make()->each(function (Document $doc) {
            $doc->save();
        });

        $testDoc = Document::create([
            'id' => 'testingPHPUnitGet',
            'payload' => '{"DONT": "MAKE THIS", "sparta": ["FUS", "RO", "DAHHHH!!!"]}'
        ]);
        $testDoc->save();

        $testDocPublished = Document::create([
            'id' => 'testingPHPUnitEditPublished',
            'status' => 'published',
            'payload' => '{"this": "is", "sparta": ["FUS", "RO", "DAHHHH!!!"]}'
        ]);
        $testDocPublished->save();

        $testDoc = Document::create([
            'id' => 'testingPHPUnitPublishAlreadyPublished',
            'payload' => '{"You": "really", "think so?": ["FUS", "RO", "DAHHHH!!!"]}'
        ]);
        $testDoc->save();

    }
}
