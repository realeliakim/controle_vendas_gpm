<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserTypeResource;

class SectionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return SectionResource::collection(Section::all());
    }

}
