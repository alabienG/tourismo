<?php


namespace App\services;


use App\Http\Resources\DictionnaireResource;
use App\interfaces\IDictionnaire;
use App\Models\Dictionnaire;
use App\Models\Lieu;
use App\utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DictionnaireService implements IDictionnaire
{

    public function save(Request $request)
    {
        $data = $request->only("name", "pays", "region", "ville", "parent");

        $validator = Validator::make($data, [
            "name" => "required|string|min:4",
            "pays" => "required",
            "region" => "required",
            "ville" => "required",
            "parent" => "numeric",
        ]);
        if ($validator->fails()) {
            return \response()->json([$validator->errors()]);
        }
        $dico = new Dictionnaire();
        $dico->nom = $request->name;
        $dico->pays = $request->pays;
        $dico->region = $request->region;
        $dico->ville = $request->ville;
        $dico->parent = $request->parent;
        $dico->save();
        return response()->json(["message" => "Succès", "data" => DictionnaireResource::make($dico)], Response::HTTP_CREATED);

    }

    public function update(Request $request, int $idDico)
    {
        $dico = Dictionnaire::where("id", $idDico)->first();
        if ($dico) {
            $data = $request->only("name", "pays", "region", "ville", "parent");

            $validator = Validator::make($data, [
                "name" => "required|string|min:4",
                "pays" => "required",
                "region" => "required",
                "ville" => "required",
            ]);
            if ($validator->fails()) {
                return \response()->json([$validator->errors()]);
            }
            $dico->nom = $request->name;
            $dico->pays = $request->pays;
            $dico->region = $request->region;
            $dico->ville = $request->ville;
            $dico->parent = $request->parent;
            $dico->save();
            return response()->json(["message" => "Succès", "data" => DictionnaireResource::make($dico)], Response::HTTP_CREATED);

        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }

    public function delete(int $idDico)
    {
        $dico = Dictionnaire::where("id", $idDico)->first();
        if ($dico) {
            $lieux = Lieu::all()->where("dictionnaire", $idDico);
            if (count($lieux) > 0) {
                return response()->json(["message' => 'Cette ressource ne peut pas être supprimer", 'data' => null], Response::HTTP_NOT_ACCEPTABLE);
            } else {
                $dico->delete();
                return response()->json(['message' => 'Succès', 'data' => true], Response::HTTP_OK);
            }
        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }

    public function all()
    {
        $all = Dictionnaire::all();
        return response()->json(["message" => "Succès", "data" => DictionnaireResource::collection($all)], Response::HTTP_OK);
    }


    public function getChildrens($idDico)
    {
        $dico = Dictionnaire::where("id", $idDico)->first();
        $childrens = [];
        if ($dico->getType() == Constantes::$pays) {
            $childrens = Dictionnaire::where("region", true)->where("parent", $idDico)->get();
        } else if ($dico->getType() == Constantes::$region) {
            $childrens = Dictionnaire::where("ville", true)->where("parent", $idDico)->get();
        } else {
            $childrens = [];
        }
        return $childrens;
    }

    public function childrens($idDico)
    {
        $childrens = $this->getChildrens($idDico);
        return response()->json(["message" => "Succès", "data" => DictionnaireResource::collection($childrens)], Response::HTTP_OK);
    }
}
