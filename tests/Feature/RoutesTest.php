<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoutesTest extends TestCase
{
    private $documentStructure = [
        "id",
        "status",
        "payload",
        "createAt",
        "modifyAt"
    ];

    private $patchContent = [
        "document" => [
            "payload" => [
                "test" => "isPassed",
                "or" => "not",
                "it's" => [
                    "all" => "have the chance"
                ],
                "so enjoy int" => "5"
            ]
        ]
    ];


    public function testGetList()
    {
        $response = $this->get("/api/v1/document");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "document" => [
                $this->documentStructure
            ],
            "pagination" => [
                "page",
                "perPage",
                "total"
            ]
        ]);
    }

    public function testGetListInvalidGETParams()
    {
        $response = $this->get("/api/v1/document/?page=1000000&perPage=-2");
        $response->assertStatus(200);
        $response->assertJson([
            "pagination" => [
                "page" => 1,
                "perPage" => 20
            ]
        ]);
    }


    public function testGetDocument()
    {
        $response = $this->get("/api/v1/document/09b9fdc4-f631-3590-a1c0-c0bf75252686",
            ["Accept" => "application/json"]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "document" => $this->documentStructure
        ]);
    }

    public function testGetDocumentNotFound()
    {
        $response = $this->get("/api/v1/document/thisisnotexisting");

        $response->assertStatus(404);
        $response->assertJsonStructure([
            "document"
        ]);
        $response->assertJsonMissing([
            "document" => ["id"]
        ]);
    }


    public function testEditDocumentResponse()
    {
        $responseJson = $this->post('/api/v1/document')->json();
        $id = $responseJson['document']['id'];
        $response = $this->patch("/api/v1/document/$id", $this->patchContent);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "document" => $this->documentStructure
        ]);
    }

    public function testEditDocumentNotFound()
    {
        $response = $this->patch("/api/v1/document/dontexists", $this->patchContent);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            "document"
        ]);
        $response->assertJsonMissing([
            "document" => ["id"]
        ]);
    }

    public function testEditPublished()
    {
        $testJSON = $this->get('/api/v1/document/09b9fdc4-f631-3590-a1c0-c0bf75252686')->json();
        $response = $this->patch("/api/v1/document/09b9fdc4-f631-3590-a1c0-c0bf75252686", $this->patchContent);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            "document" => $this->documentStructure
        ]);
        $response->assertJson($testJSON);
    }


    public function testPublish()
    {
        $newTestDocument = $this->post("/api/v1/document")->json();
        $id = $newTestDocument['document']['id'];
        $response = $this->post("/api/v1/document/$id/publish");

        $response->assertStatus(200);
        $response->assertJsonStructure(["document" => $this->documentStructure]);
    }

    public function testPublishAlreadyPublished()
    {
        $idPublished = '09b9fdc4-f631-3590-a1c0-c0bf75252686';
        $response = $this->post("/api/v1/document/$idPublished/publish");

        $response->assertStatus(200);
        $response->assertJsonStructure(["document" => $this->documentStructure]);
    }


    public function get($uri, array $headers = [])
    {
        return parent::getJson($uri, $headers);
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        return parent::postJson($uri, $data, $headers);
    }

    public function patch($uri, array $data = [], array $headers = [])
    {
        return parent::patchJson($uri, $data, $headers);
    }
}
