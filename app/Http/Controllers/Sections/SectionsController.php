<?php

namespace App\Http\Controllers\Sections;

use App\Models\grades;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\classrooms;
use Flasher\Toastr\Prime\ToastrFactory;

class SectionsController extends Controller
{

    public function index()
    {
        $Grades = grades::with(['Sections'])->get();

        $list_Grades = grades::all();

        return view('pages.Sections.Sections', compact('Grades', 'list_Grades'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request, ToastrFactory $flasher)
    {


        try {

            // $validated = $request->validated();

            $sections = new sections();

            $sections->section_name = ['en' => $request->section_name_en, 'ar' => $request->section_name_ar];
            $sections->grade_id = $request->grade_id;
            $sections->class_id = $request->class_id;
            $sections->status = 1;

            $sections->save();




            $flasher->addFlash('success', 'messages.success');
            return redirect()->route('Sections.index');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function show(sections $sections)
    {
        //
    }


    public function edit(sections $sections)
    {
        //
    }


    public function update(Request $request, ToastrFactory $flasher)
    {
        try {
            $sections = sections::FindOrFail($request->id);
            $sections->update([

                $sections->section_name = ['en' => $request->section_name_en, 'ar' => $request->section_name_ar],
                $sections->grade_id = $request->grade_id,
                $sections->class_id = $request->class_id,

            ]);

            if (isset($request->status)) {
                $sections->status = 1;
            } else {
                $sections->status = 2;
            }

            $sections->save();

            $flasher->addFlash('success', 'messages.success');
            return back();
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(request $request, ToastrFactory $flasher)
    {
        sections::FindOrFail($request->id)->delete();

        $flasher->addFlash('error', 'messages.delete', null);
        return back();
    }


    public function GetClasses($id)
    {
        $list_classes = classrooms::Where('grade_id', $id)->pluck('class_name', 'id');

        return $list_classes;
    }
}
