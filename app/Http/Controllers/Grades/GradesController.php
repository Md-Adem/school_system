<?php

namespace App\Http\Controllers\Grades;

use App\Models\grades;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGrades;
use App\Http\Controllers\Controller;
use App\Models\classrooms;
use Flasher\Toastr\Prime\ToastrFactory;

class GradesController extends Controller
{

    public function index()
    {
        $grades = grades::all();

        return view('pages.Grades.Grades', compact('grades'));
    }


    public function create()
    {
        //
    }


    public function store(StoreGrades $request, ToastrFactory $flasher)
    {
        // check if its uniqe or note means check validation in the controller
        // if (grades::where('name->ar', $request->name)->orWhere('name->en', $request->name_en)->exists()) {

        //     $flasher->addFlash('error', 'grades_trans.exists');
        //     return redirect()->back();
        // }


        try {
            $validated = $request->validated();
            $grades = new grades();

            // save in DB with two translation
            // first method
            // $translations = [
            //     'en' => $request->name_en,
            //     'ar' => $request->name
            // ];

            // $grades->setTranslations('name', $translations);

            // Second method
            $grades->name = ['en' => $request->name_en, 'ar' => $request->name];
            $grades->notes = $request->notes;

            $grades->save();

            $flasher->addFlash('success', 'messages.success');
            // $flasher->addSuccess(trans('messages.success'));
            return redirect()->route('Grades.index');

            //if there any error show it in alert not in debugin mode
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function show(grades $grades)
    {
        //
    }


    public function edit(grades $grades)
    {
        //
    }


    public function update(StoreGrades $request, ToastrFactory $flasher)
    {
        try {
            $validated = $request->validated();
            $grades = grades::findOrfail($request->id);
            $grades->update([
                $grades->name = ['en' => $request->name_en, 'ar' => $request->name],
                $grades->notes = $request->notes,
            ]);

            $flasher->addFlash('success', 'messages.update');
            return redirect()->route('Grades.index');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(request $request, ToastrFactory $flasher)
    {
        $ThereClasses = classrooms::where('grade_id', $request->id)->pluck('grade_id');

        if ($ThereClasses->count() == 0) {

            grades::findOrfail($request->id)->delete();

            $flasher->addFlash('error', 'messages.delete');
            return redirect()->route('Grades.index');
        } else {

            $flasher->addFlash('error', 'grades_trans.delete_Grade_Error');
            return redirect()->route('Grades.index');
        }
    }
}
