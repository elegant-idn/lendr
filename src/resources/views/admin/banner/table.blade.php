<table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">



    <thead>



        <tr class="text-uppercase fw-500">



            <td>{{ trans('labels.srno') }}</td>



            <td>{{ trans('labels.image') }}</td>



            <td>{{ trans('labels.category') }}</td>



            <td>{{ trans('labels.product') }}</td>

            @if ($section == 1)

                <td>{{ trans('labels.title') }}</td>

                <td>{{ trans('labels.subtitle') }}</td>

                <td>{{ trans('labels.link_text') }}</td>

            @endif



            <td>{{ trans('labels.status') }}</td>



            <td>{{ trans('labels.action') }}</td>



        </tr>



    </thead>



    <tbody>



        @php

        $i = 1;

        @endphp



        @foreach ($getbanner as $item)

            @if ($item->section == $section)

                <tr class="fs-7">



                    <td>

                        @php

                        

                        echo $i++;

                        

                    @endphp

                    </td>



                    <td><img src="{{ helper::image_path($item->image) }}"

                            class="img-fluid rounded hw-50 object-fit-cover" alt=""></td>



                    <td>



                        @if ($item->type == '1')

                            {{ @$item['category_info']->name }}

                        @else

                            --

                        @endif



                    </td>



                    <td>



                        @if ($item->type == '2')

                            {{ @$item['product_info']->title }}

                        @else

                            --

                        @endif



                    </td>

                    @if ($section == 1)

                        <td>{{ $item->title }}</td>

                        <td>{{ $item->sub_title }}</td>

                        <td>{{ $item->link_text }}</td>

                    @endif

                    <td>



                        @if ($item->is_available == '1')

                            <a href="javascript:void(0)"

                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else



                            onclick="statusupdate('{{ URL::to('admin/' . $url . '/status_change-' . $item->id . '/2') }}')" @endif

                                class="btn btn-sm btn-outline-success"><i class="fa-regular fa-check"></i></a>

                        @else

                            <a href="javascript:void(0)"

                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else



                            onclick="statusupdate('{{ URL::to('admin/' . $url . '/status_change-' . $item->id . '/1') }}')" @endif

                                class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-xmark"></i></a>

                        @endif



                    </td>



                    <td>



                        <a href="{{ URL::to('admin/' . $url . '/edit-' . $item->id) }}" class="btn btn-outline-primary btn-sm">

                            <i class="fa-regular fa-pen-to-square"></i></a>



                        <a href="javascript:void(0)"

                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else



                        onclick="statusupdate('{{ URL::to('admin/' . $url . '/delete-' . $item->id) }}')" @endif

                            class="btn btn-outline-danger btn-sm"> <i class="fa-regular fa-trash"></i></a>



                    </td>



                </tr>

            @endif

        @endforeach



    </tbody>



</table>

