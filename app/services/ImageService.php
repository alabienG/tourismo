<?php


namespace App\services;


use App\Http\Resources\ImageResource;
use App\interfaces\ImageInterface;
use App\Models\Image;
use App\Models\Lieu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageService implements ImageInterface
{


    public function addImage(Request $request, $idLieu)
    {
        if ($request->hasFile('photo')) {
            $path = $request->file('photo');
            $name = 'images' . random_int(1, 100000) . '.' . $path->getClientOriginalExtension(); // generer un  nom de fichier
            $path->storeAs("public/lieu/", $name);

            $media = new Image();
            $media->path = $name;
            $media->lieu = $idLieu;
            $media->extension = $path->getClientOriginalExtension();
            $media->save();
            return \response()->json(['message' => 'Media ajouté', "data" => ImageResource::make($media)], 201);

        } else {
            return \response()->json(['erreur' => "Veuillez choisir une image"], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
