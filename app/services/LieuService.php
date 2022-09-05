<?php


namespace App\services;


use App\Http\Resources\LieuResource;
use App\interfaces\IDictionnaire;
use App\interfaces\ILieu;
use App\Models\Dictionnaire;
use App\Models\Lieu;
use App\utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\fromJSON;

class LieuService implements ILieu
{

    private $dicoService;

    public function __construct(DictionnaireService $dicoService)
    {
        $this->dicoService = $dicoService;
    }

    public function save(Request $request)
    {
        $data = $request->only("nom", "description", "lieu");

        $validator = Validator::make($data, [
            "nom" => "required|string|min:5",
            "description" => "string",
            "lieu" => "required|numeric"
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $lieu = new Lieu();
        $lieu->nom = $request->nom;
        $lieu->description = $request->description;
        $lieu->dictionnaire = $request->lieu;
        $lieu->user = Auth::id();
        $lieu->save();

        return \response()->json(['message' => "Succès", "data" => LieuResource::make($lieu)], Response::HTTP_CREATED);

    }

    public function update(Request $request, int $idLieu)
    {
        $lieu = Lieu::where("id", $idLieu)->first();
        if ($lieu) {
            if (Auth::id() === $lieu->user) {
                $data = $request->only("nom", "description", "lieu");

                $validator = Validator::make($data, [
                    "nom" => "required|string|min:5",
                    "description" => "string",
                    "lieu" => "required|numeric"
                ]);

                if ($validator->fails()) {
                    return $validator->errors();
                }
                $lieu->nom = $request->nom;
                $lieu->description = $request->description;
                $lieu->dictionnaire = $request->lieu;
                $lieu->save();

                return \response()->json(['message' => "Succès", "data" => LieuResource::make($lieu)], Response::HTTP_CREATED);
            } else {
                return response()->json(["message" => "Vous ne pouvez pas modifier cet élément", "data" => null], Response::HTTP_NOT_ACCEPTABLE);
            }

        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }

    public function show(int $idLieu)
    {
        $lieu = Lieu::where("id", $idLieu)->first();
        if ($lieu) {
            return response()->json(['message' => "Succès", "data" => LieuResource::make($lieu)], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }

    public function delete(int $idLieu)
    {
        $lieu = Lieu::where("id", $idLieu)->first();
        if ($lieu) {
            $lieu->delete();
            return response()->json(['message' => "Succès", "data" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }

    public function getAllLieux()
    {
        $all = Lieu::all();
        return response()->json(["message" => "Succès", "data" => LieuResource::collection($all)], Response::HTTP_OK);
    }

    public function getLieuByDico(int $idDico)
    {
        $dico = Dictionnaire::where("id", $idDico)->first();
        $result = [];
        if ($dico) {
            $result = Lieu::all()->where("dictionnaire", $dico->id);
            $childrens = $this->dicoService->getChildrens($idDico);
            //enfant
            if (count($childrens) > 0) {
                if (count($childrens) > 0) {
                    foreach ($childrens as $children) {
                        $datas = Lieu::all()->where("dictionnaire", $children->id);
                        if (count($datas) > 0) {
                            foreach ($datas as $data) {
                                $result->add($data);
                            }

                        }

                        // enfant de l'enfant
                        $otherChildrens = $this->dicoService->getChildrens($children->id);
                        if (count($otherChildrens) > 0) {
                            foreach ($otherChildrens as $otherChildren) {
                                $otherDatas = Lieu::all()->where("dictionnaire", $otherChildren->id);
                                if (count($otherDatas) > 0) {
                                    foreach ($otherDatas as $otherData) {
                                        $result->add($otherData);
                                    }
                                }
                            }
                        }

                    }
                }
            }

            return response()->json(["message" => "Succès", "data" => LieuResource::collection($result)], Response::HTTP_OK);

        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }

    public function likes(int $idLieu)
    {

        $id = Auth::id();
        $lieu = Lieu::where("id", $idLieu)->first();
        if ($lieu) {
            $usersLikes = explode(",", $lieu->usersLiked);

            if (in_array($id, $usersLikes)) {
                return response()->json(['message' => "Ce lieu fait déjà parti de vos favoris", 'data' => false], Response::HTTP_NOT_ACCEPTABLE);
            } else {
                $usersLikes[] = $id;
                $lieu->usersLiked = implode(",", $usersLikes);
                // on verifie s'il exsite dans userDisliked
                $usersDislikes = explode(",", $lieu->usersDisliked);
                if (in_array($id, $usersDislikes)) {
                    $newUserDisliked = array_diff($usersDislikes, array($id));
                    $lieu->usersDisliked = implode(",", $newUserDisliked);
                    $lieu->dislikes--;
                }
                $lieu->likes++;
                $lieu->updated_at = now();
                $lieu->save();
                return response()->json(["message" => "Succès", "data" => true], Response::HTTP_OK);
            }
        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }


    public function disLikes(int $idLieu)
    {
        $id = Auth::id();
        $lieu = Lieu::where("id", $idLieu)->first();
        if ($lieu) {
            $usersDislikes = explode(",", $lieu->usersDisliked);

            if (in_array($id, $usersDislikes)) {
                return response()->json(['message' => "Ce lieu ne fait pas parti de vos favoris", 'data' => false], Response::HTTP_NOT_ACCEPTABLE);
            } else {
                $usersDislikes[] = $id;
                $lieu->usersDisliked = implode(",", $usersDislikes);
                // on verifie s'il exsite dans userLiked
                $usersLikes = explode(",", $lieu->usersLiked);
                if (in_array($id, $usersLikes)) {
                    $newUserliked = array_diff($usersLikes, array($id));
                    $lieu->usersLiked = implode(",", $newUserliked);
                    $lieu->likes--;
                }
                $lieu->dislikes++;
                $lieu->updated_at = now();
                $lieu->save();
                return response()->json(["message" => "Succès", "data" => true], Response::HTTP_OK);
            }
        } else {
            return response()->json(["message" => "NOT FOUND", "data" => null], Response::HTTP_NOT_FOUND);
        }
    }
}
