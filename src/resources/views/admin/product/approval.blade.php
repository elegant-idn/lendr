@extends('admin.layout.default')

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <form id="myForm" method="POST" action="{{ URL::to('/admin/products/approval-selected') }}" onsubmit="return confirm()">
                        @csrf
                        <div class="table-responsive">
                            <div class="mb-2 float-end position-relative" style="z-index:1 !important">
                                <button type="submit" name="action" value="approve" class="btn btn-outline-success btn-sm" style="width:50px !important;height:40px"><i class="fa-regular fa-check"></i></button>
                                <button type="submit" name="action" value="delete" class="btn btn-outline-danger btn-sm ml-2" style="width:50px !important;height:40px"><i class="fa-regular fa-trash"></i></button>
                            </div>
                            <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                                <thead>
                                    <tr class="text-uppercase">
                                        <td class="tc-title"><input type="checkbox" id="select-all"></td>
                                        <td class="tc-title">{{ trans('labels.image') }}</td>
                                        <td class="tc-title">{{ trans('labels.title') }}</td>
                                        <td class="tc-title">{{ trans('labels.category') }}</td>
                                        {{-- <td class="tc-title">{{ trans('labels.per_hour_price') }}</td> --}}
                                        <td class="tc-title">{{ trans('labels.per_day_price') }}</td>
                                        {{-- <td class="tc-title">{{ trans('labels.tax') }}</td> --}}
                                        <td class="tc-title">{{ trans('labels.action') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)
                                            <tr class="fs-7">
                                                <td>
                                                    <input type="checkbox" name="selected_products[]" value="{{ $item->id }}">
                                                </td>
                                                
                                                <td>
                                                    @if(isset($item->product_image_api[0]) && isset($item->product_image_api[0]->image))
                                                        <img src="{{ $item->product_image_api[0]->image }}" class="img-fluid rounded hw-70" alt="">
                                                    @endif
                                                </td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item['category_info']->name }}</td>
                                                {{-- <td>{{ $item->per_hour_price }} $</td> --}}
                                                <td>{{ $item->per_day_price }} $</td>
                                                {{-- <td>{{ $item->tax }}%</td> --}}
                                                <td>
                                                    <a href="{{ URL::to('/admin/products/view/' . $item->slug) }}"class="btn btn-outline-info btn-sm">
                                                        <i class="fa-regular fa-circle-info"></i>                                                    
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                        onclick="statusupdate('{{ URL::to('/admin/products/delete-' . $item->slug) }}')"
                                                        class="btn btn-outline-danger btn-sm"> <i
                                                            class="fa-regular fa-trash"></i></a>
                                                </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            const sortingElements = document.querySelectorAll('td.tc-title');
            const updatedSortingArray = Array.from(sortingElements).slice(1);

            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectAllCheckbox);
            });

            updatedSortingArray.forEach(sortingElement => {
                sortingElement.addEventListener('click', function () {
                    checkboxes.forEach(checkbox => checkbox.checked = false);
                    selectAllCheckbox.checked = false;
                });
            });

            function updateSelectAllCheckbox() {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
            }
        });

        function confirm() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-1',
                    cancelButton: 'btn btn-danger mx-1'
                },
                buttonsStyling: false
            });

            const clickedButton = event.submitter;
            const action = clickedButton.value;

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'action';
                hiddenInput.value = action;
                document.getElementById("myForm").appendChild(hiddenInput);

                // Submit the form
                document.getElementById("myForm").submit();
            }
            });
            return false;
        }
    </script>
@endsection

