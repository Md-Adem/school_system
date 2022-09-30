@extends('layouts.master')
@section('css')

@section('title')
    {{ trans('classes_trans.title_page') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('classes_trans.title_page') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">

    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                    {{ trans('classes_trans.add_class') }}
                </button>

                <button type="button" class="button x-small" id="btn_delete_all">
                    {{ trans('classes_trans.delete_checkbox') }}
                </button>


                <br><br>
                <div class="row">
                    <form action="{{ route('filter_classes', 'test') }}" method="POST">
                        {{ csrf_field() }}
                        <select class="selectpicker" data-style="btn-info" name="grade_id" required
                            onchange="this.form.submit()">
                            <option value="" selected disabled>{{ trans('classes_trans.Search_By_Grade') }}
                            </option>
                            @foreach ($Grades as $Grade)
                                <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('Classrooms.index') }}" class="btn btn-white btn-sm "role="button"
                        aria-disabled="true">{{ trans('classes_trans.Clear') }}</a>
                </div>




                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th><input name="select_all" id="example-select-all" type="checkbox"
                                        onclick="CheckAll('box1', this)" /></th>
                                <th>#</th>
                                <th>{{ trans('classes_trans.Name_class') }}</th>
                                <th>{{ trans('classes_trans.Name_Grade') }}</th>
                                <th>{{ trans('classes_trans.Processes') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (isset($filter))
                                <?php $List_Classes = $filter; ?>
                            @else
                                <?php $List_Classes = $Classes; ?>
                            @endif

                            <?php $i = 0; ?>

                            @foreach ($List_Classes as $Class)
                                <tr>
                                    <?php $i++; ?>
                                    <td><input type="checkbox" value="{{ $Class->id }}" class="box1"></td>
                                    <td>{{ $i }}</td>
                                    <td>{{ $Class->class_name }}</td>
                                    <td>{{ $Class->grades->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $Class->id }}"
                                            title="{{ trans('grades_trans.Edit') }}"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $Class->id }}"
                                            title="{{ trans('grades_trans.Delete') }}"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- edit_modal_Grade -->
                                <div class="modal fade" id="edit{{ $Class->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('classes_trans.edit_class') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- edit_form -->
                                                <form action="{{ route('Classrooms.update', 'test') }}" method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name"
                                                                class="mr-sm-2">{{ trans('classes_trans.Name_class') }}
                                                                :</label>
                                                            <input id="Name" type="text" name="class_name"
                                                                class="form-control"
                                                                value="{{ $Class->getTranslation('class_name', 'ar') }}"
                                                                required>
                                                            <input id="id" type="hidden" name="id"
                                                                class="form-control" value="{{ $Class->id }}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="Name_en"
                                                                class="mr-sm-2">{{ trans('classes_trans.Name_class_en') }}
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $Class->getTranslation('class_name', 'en') }}"
                                                                name="class_name_en" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group">
                                                        <label
                                                            for="exampleFormControlTextarea1">{{ trans('classes_trans.Name_Grade') }}
                                                            :</label>
                                                        <select class="form-control form-control-lg"
                                                            id="exampleFormControlSelect1" name="grade_id">
                                                            <option value="{{ $Class->Grades->id }}">
                                                                {{ $Class->Grades->name }}
                                                            </option>
                                                            @foreach ($Grades as $Grade)
                                                                <option value="{{ $Grade->id }}">
                                                                    {{ $Grade->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <br><br>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('grades_trans.Close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-success">{{ trans('grades_trans.submit') }}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete{{ $Class->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('classes_trans.delete_class') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('Classrooms.destroy', 'test') }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    {{ trans('classes_trans.Warning_Grade') }}
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $Class->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('classes_trans.Close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ trans('classes_trans.Delete') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- add_modal_class -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        {{ trans('classes_trans.add_class') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class=" row mb-30" action="{{ route('Classrooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="List_Classes">
                                    <div data-repeater-item>
                                        <div class="row">

                                            <div class="col">
                                                <label for="name"
                                                    class="mr-sm-2">{{ trans('classes_trans.Name_class') }}
                                                    :</label>
                                                <input class="form-control" type="text" name="class_name" />
                                            </div>


                                            <div class="col">
                                                <label for="name"
                                                    class="mr-sm-2">{{ trans('classes_trans.Name_class_en') }}
                                                    :</label>
                                                <input class="form-control" type="text" name="class_name_en" />
                                            </div>


                                            <div class="col">
                                                <label for="Name_en"
                                                    class="mr-sm-2">{{ trans('classes_trans.Name_Grade') }}
                                                    :</label>

                                                <div class="box">
                                                    <select class="fancyselect" name="grade_id">
                                                        @foreach ($Grades as $Grade)
                                                            <option value="{{ $Grade->id }}">{{ $Grade->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col">
                                                <label for="Name_en"
                                                    class="mr-sm-2">{{ trans('classes_trans.Processes') }}
                                                    :</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete
                                                    type="button" value="{{ trans('classes_trans.delete_row') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button" data-repeater-create type="button"
                                            value="{{ trans('classes_trans.add_row') }}" />
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                    <button type="submit"
                                        class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>

    </div>
</div>



<!-- delete all modal -->
<div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('classes_trans.delete_class') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('delete_all', 'test') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    {{ trans('classes_trans.Warning_Grade') }}
                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('classes_trans.Close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('classes_trans.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>



</div>

</div>

<!-- row closed -->
@endsection
@section('js')

<script type="text/javascript">
    $(function() {
        $("#btn_delete_all").click(function() {
            var selected = new Array();
            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#delete_all').modal('show')
                $('input[id="delete_all_id"]').val(selected);
            }
        });
    });
</script>




@endsection
