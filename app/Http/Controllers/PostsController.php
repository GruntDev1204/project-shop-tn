<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Http\Requests\PostReq;
use App\Models\posts;
use App\Service\extend\IServicePost;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    private $postSV;
    public function __construct(IServicePost $postSV)
    {
        $this->postSV = $postSV;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {
        $this->getAuth();
        $request->merge([
            'user_id' => $this->getAuth()->id,
            'is_own' => $request->query('is_own')
        ]);
        return $this->returnJson($this->postSV->getAll($request), 200, "success!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PostReq $req)
    {
        $user = $this->getAuth();
        $req->merge(['user_id' => $user->id]);
        return $this->returnJson($this->postSV->create($req->all()), 201, "success!");
    }

    public function update(Request $request, posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->getAuth();
        if ($this->getAuth()->id != $this->postSV->findById($id)->user_id) throw new APIException(403, "FORBIDDEN!");
        return $this->returnJson($this->postSV->delete($id), 204, "success!");
    }
}
