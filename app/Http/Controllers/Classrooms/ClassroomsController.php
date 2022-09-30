<?php

namespace App\Http\Controllers\Classrooms;

use App\Models\grades;
use App\Models\classrooms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Http\Requests\StoreClassRequest;

class ClassroomsController extends Controller
{

    public function index()
    {
        $Grades = grades::all();

        $Classes = classrooms::all();

        return view('pages.Classes.Classes', compact('Grades', 'Classes'));
    }


    public function create()
    {
        //
    }


    public function store(StoreClassRequest $request, ToastrFactory $flasher)
    {
        $List_Classes = $request->List_Classes;

        $validated = $request->validated();

        try {



            // becuose our request is array we need a forech to extract each one
            foreach ($List_Classes as $List_Class) {

                $classrooms = new classrooms();

                $classrooms->class_name = ['en' => $List_Class['class_name_en'], 'ar' => $List_Class['class_name']];
                $classrooms->grade_id = $List_Class['grade_id'];

                $classrooms->save();
            }



            $flasher->addFlash('success', 'messages.success');
            return redirect()->route('Classes.index');

            //if there any error show it in alert not in debugin mode
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function show(classrooms $classrooms)
    {
        //
    }


    public function edit(classrooms $classrooms)
    {
        //
    }

    public function update(Request $request, ToastrFactory $flasher)
    {
        try {
            $classrooms = classrooms::FindOrFail($request->id);
            $classrooms->update([

                $classrooms->class_name = ['en' => $request->class_name_en, 'ar' => $request->class_name],
                $classrooms->grade_id = $request->grade_id
            ]);

            $flasher->addFlash('success', 'messages.success');
            return back();
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(Request $request, ToastrFactory $flasher)
    {
        classrooms::FindOrFail($request->id)->delete();

        $flasher->addFlash('error', 'messages.delete', null);
        return back();
    }


    public function delete_all(Request $request, ToastrFactory $flasher)
    {
        // explode() method is takin multiple numbers and put it in array
        $delete_all_id = explode(",", $request->delete_all_id);

        // WhereIn() method is takin arrays, but where is takein only one id
        classrooms::WhereIn('id', $delete_all_id)->delete();

        $flasher->addFlash('error', 'messages.delete', null);
        return back();
    }

    public function filter_classes(Request $request, ToastrFactory $flasher)
    {
        $Grades = grades::all();

        $filter = classrooms::select('*')->Where('grade_id', $request->grade_id)->get();

        return view('pages.Classes.Classes', compact('Grades', 'filter'));
    }
}
