<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function create()
    {
        $uuid = Str::uuid()->toString();
        return [
            "document" => Document::create(['id' => $uuid])
        ];
    }

    public function get(Document $document)
    {
        return ["document" => $document];
    }

    public function edit(Request $request, Document $document)
    {
        $requestDocument = $request->get('document');
        $requestPayload = $requestDocument['payload'] ?? null;

        if ($document->status === "published") {
            return response()->json(["document" => $document], 400);
        }
        if ($requestPayload === null) {
            return response()->json(["document" => $document], 400);
        }

        $document->payload = json_encode($requestPayload);
        $document->save();

        return ["document" => $document];
    }

    public function publish(Document $document)
    {
        $document->status = "published";
        $document->save();

        return ["document" => $document];
    }

    public function getList(Request $request)
    {
        $page = ($request->has('page') && $request->get('page') > 0) ?
            $request->get('page') :
            1;
        $perPage = ($request->has('perPage') && $request->get('perPage') > 0) ?
            $request->get('perPage') :
            20;

        $total = Document::all()->count();
        if ($total < $page * $perPage) {
            $page = 1;
        }
        $documents = Document::limit($perPage)->offset(($page - 1) * $perPage)->get()->toArray();

        return [
            "document" => $documents,
            "pagination" => [
                "page" => $page,
                "perPage" => $perPage,
                "total" => $total
            ]
        ];
    }
}
