<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resource::latest('created_at')->get();

        return Inertia::render('List', [
            'resources' => $resources
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        request()->validate([
            'pdf_title' => 'required',
            'snippet_title' => 'required',
            'snippet_content' => 'required',
            'link_title' => 'required',
            'link' => 'required',
            'file' => 'required|file|mimes:ppt,pptx,doc,docx,pdf,xls,xlsx|max:204800',
        ]);

        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

        $pdf_name = time().'_'.$request->file->getClientOriginalName();
        $pdf_path = '/storage/' . $file_path;

        Resource::create([
            'pdf_title' => $request->input('pdf_title'),
            'snippet_title' => $request->input('snippet_title'),
            'snippet_content' => $request->input('snippet_content'),
            'link_title' => $request->input('link_title'),
            'link' => $request->input('link'),
            'pdf_name' => $pdf_name,
            'pdf_path' => $pdf_path
        ]);

        session()->flash('message', 'Resource created successfully.');

        //inertia redirect
        return Redirect::route('resources.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
         $resource = Resource::find($resource->id);

        return Inertia::render('Admin/Edit', [
            'resource' => $resource
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        // validate
        $attributes = $request->validate([
            'pdf_title' => 'required',
            'snippet_title' => 'required',
            'snippet_content' => 'required',
            'link_title' => 'required',
            'link' => 'required',
        ]);

        session()->flash('message', 'Resource updated successfully.');
        $resource->update($attributes);

        //inertia redirect
//        return Redirect::route('resources.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();

        session()->flash('message', 'Resource deleted successfully.');
    }
}
