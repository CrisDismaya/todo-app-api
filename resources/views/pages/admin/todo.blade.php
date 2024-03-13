@extends('layout.dashboard')
@section('title', 'Manage Branches')

@section('custom-css')

@endsection

@section('content')
    <div class="card">
        <div class="d-flex card-header justify-content-between align-items-center">
            <h4 class="header-title">Manage Branches</h4>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#branch-modal" onclick="empty_fields()">
                <i class="uil-plus"></i> Add Branch
            </button>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th class="text-sm-start not-export-col">Action</th>
                    </thead>
                </table>
            </div> <!-- end table-responsive-->

        </div> <!-- end card-body-->
    </div>

    <div class="modal fade" id="branch-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel"> Add Branch </h4>
                    <button type="button" class="btn-sm btn-close modal-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="branch-code">Code</label>
                                    <input class="form-control" type="text" placeholder="Enter your code" id="branch-code" />
                                    <p class="error-message text-danger" id="branch-code-error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="branch-name">Name</label>
                                    <input class="form-control" type="text" placeholder="Enter your name" id="branch-name" />
                                    <p class="error-message text-danger" id="branch-name-error"></p>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="branch-email-address">Email Address</label> <small class="text-muted">(Optional)</small>
                                    <input class="form-control" type="email" placeholder="Enter your email" id="branch-email" />
                                    <p class="error-message text-danger" id="branch-email-error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="branch-phone">Phone</label> <small class="text-muted">(Optional)</small>
                                    <input class="form-control" type="text" placeholder="(xx) xxx xxxx xxx" id="branch-phone" />
                                    <p class="error-message text-danger" id="branch-phone-error"></p>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="branch-address">Address</label>
                                    <input class="form-control" type="text" placeholder="Enter full address" id="branch-address">
                                    <p class="error-message text-danger" id="branch-address-error"></p>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-1">
                                    <label for="branch-province">Province</label>
                                    <select id="branch-province" class="form-control select2-modal" data-toggle="select2-modal">
                                        <option value="">Select</option>
                                    </select>
                                    <p class="error-message text-danger" id="branch-province-error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-1">
                                    <label for="branch-city">City</label>
                                    <select id="branch-city" class="form-control select2-modal" data-toggle="select2-modal">
                                        <option value="">Select</option>
                                    </select>
                                    <p class="error-message text-danger" id="branch-city-error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-1">
                                    <label for="branch-barangay">Barangay</label>
                                    <select id="branch-barangay" class="form-control select2-modal" data-toggle="select2-modal">
                                        <option value="">Select</option>
                                    </select>
                                    <p class="error-message text-danger" id="branch-barangay-error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <p>
                                    <button id="branch-location" class="btn btn-outline-secondary btn-sm" type="button"
                                        data-bs-toggle="collapse"
                                        aria-expanded="false" aria-controls="collapseGoogleMaps">
                                        <i class="uil uil-map"></i> Pin Location
                                    </button>
                                    <p class="error-message text-danger" id="branch-location-error"></p>
                                </p>
                                <div class="collapse" id="collapseGoogleMaps">
                                    <div class="card card-body mb-0 p-0">
                                        <div id="branch-google-maps" style="height: 400px; width: 100%;"></div>
                                    </div>
                                </div>
                                <input type="hidden" placeholder="Enter latitude" id="branch-latitude">
                                <input type="hidden" placeholder="Enter longitude" id="branch-longitude">
                            </div>
                        </div> <!-- end row -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light modal-close" data-bs-dismiss="modal">Close</button>
                    <button id="save-branches" type="button" class="btn btn-sm btn-outline-secondary" data-update-id="0" onclick="save_branch(this.id)">
                        <span id="text"> Save Branch </span>
                        <span id="spinner" class="spinner spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>
                    </button>
                </div> <!-- end modal footer -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="branch-view-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel"> Delete Branch </h4>
                    <button type="button" class="btn-sm btn-close modal-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="row mb-1">
                            <label class="col-3 text-end col-form-label">Code :</label>
                            <div class="col-9">
                                <label  class="col-form-label view-code"> </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-3 text-end col-form-label">Name :</label>
                            <div class="col-9">
                                <label class="col-form-label view-name"> text </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-3 text-end col-form-label">Email :</label>
                            <div class="col-9">
                                <label class="col-form-label view-email"> text </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-3 text-end col-form-label">Phone :</label>
                            <div class="col-9">
                                <label class="col-form-label view-phone"> text </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-3 text-end col-form-label">Address :</label>
                            <div class="col-9">
                                <label class="col-form-label view-address"> text </label>
                            </div>
                        </div>

                        <div class="row mb-1 px-5">
                            <div class="form-check form-checkbox-danger">
                                <input type="checkbox" class="form-check-input" id="delete-confirmation">
                                <label class="form-check-label" for="delete-confirmation">Are you sure you want to delete this item?</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light modal-close" data-bs-dismiss="modal">Close</button>
                    <button id="delete-branch" type="button" class="btn btn-sm btn-outline-danger" data-delete-id="" onclick="delete_branch(this.id)">
                        <span id="text"> Delete Branch </span>
                        <span id="spinner" class="spinner spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>
                    </button>
                </div> <!-- end modal footer -->
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        var elemetGoogleMaps = 'branch-google-maps';
        $(document).ready(() => {
            table()
            $('.spinner').hide()
            get_province('branch-province')

            $('#branch-city').prop("disabled", true)
            $('#branch-barangay').prop("disabled", true)

            $('#branch-province').change(function() {
                const selectedValue = $(this).val()

                if(selectedValue){
                    get_cities('branch-city', selectedValue)
                }
                else {
                    $('#branch-city').empty().append('<option value="">Select</option>')
                }

                $('#collapseGoogleMaps').removeClass('show')
                $('#branch-city').prop("disabled", selectedValue ? false : true)
                $('#branch-barangay').prop("disabled", true)
                    .empty().append('<option value="">Select</option>')
            })

            $('#branch-city').change(function() {
                const selectedValue = $(this).val()
                if(selectedValue){
                    get_barangay('branch-barangay', selectedValue)
                }
                else {
                    $('#branch-barangay').empty().append('<option value="">Select</option>')
                }
                $('#collapseGoogleMaps').removeClass('show')
                $('#branch-barangay').prop("disabled", selectedValue ? false : true)
            })

            $('#branch-barangay').change(function() {
                $('#collapseGoogleMaps').removeClass('show')
            })

            $('#branch-location').click(function(){
                let province = $('#branch-province')
                let cities = $('#branch-city')
                let barangay = $('#branch-barangay')

                if (province.val() && cities.val() && barangay.val()) {
                    $('#collapseGoogleMaps').addClass('show')
                    $('#branch-location-error').text('')

                    const address = `${ province.find(":selected").text() }, ${ cities.find(":selected").text() }, ${ barangay.find(":selected").text() }`
                    branchGoogleMaps(elemetGoogleMaps, address)
                } else {
                    $('#branch-location-error').text('Check the address if complete')
                    $('#collapseGoogleMaps').removeClass('show')
                }
            })
        })

        function empty_fields(){
            $('#save-branches').data('update-id', "0")
            $('#branch-name').val('')
            $('#branch-code').val('')
            $('#branch-email').val('')
            $('#branch-phone').val('')
            $('#branch-address').val('')
            $('#branch-province').val('').trigger('change')
            $('#branch-city').prop("disabled", true).empty().append('<option value="">Select</option>')
            $('#branch-barangay').prop("disabled", true).empty().append('<option value="">Select</option>')
            $('#branch-latitude').val('')
            $('#branch-longitude').val('')

            $('.error-message').text('')
            $('#collapseGoogleMaps').removeClass('show')
        }

        async function table() {
            try {
                let url = `/admin/branches/show`;
                const { result } = await fetch_data(url)

                if ($.fn.DataTable.isDataTable('#basic-datatable')) {
                    $('#basic-datatable').DataTable().destroy();
                }

                var a = $("#basic-datatable").DataTable({
                    data: result, // Set the data for the DataTable
                    columns: [
                        { data: 'id', className: 'fw-semibold', visible: false, searchable: false },
                        { data: 'code', className: 'fw-semibold' },
                        { data: 'name', className: 'fw-semibold' },
                        { data: 'email' },
                        { data: 'phone' },
                        { data: 'address',
                            render: function(data, type, row, meta){
                                const word = `${ row.address }, ${ row.province.title }, ${ row.city.title }, ${ row.barangay.title }`;
                                return addEllipsis(word);
                            }
                        },
                        { data: null, defaultContent: '', className:'text-center',
                            render: function(data, type, row, meta){

                                const address = `${ row.address }, ${ row.province.title }, ${ row.city.title }, ${ row.barangay.title }`;
                                html = `
                                    <i class="ri-edit-box-line font-20 text-warning cursor-pointer"
                                        onclick="view_branch('update', ${ row.id }, '${ row.code }', '${ row.name }', '${ row.email ?? '' }', '${ row.phone ?? '' }',
                                            '${ row.address }', ${ row.province.id }, ${ row.city.id }, ${ row.barangay.id }, ${ row.latitude }, ${ row.longitude }, '${ address }')">
                                    </i>
                                    <i class="ri-subtract-line font-20 rotate-90"></i>
                                    <i class="ri-delete-bin-line font-20 text-danger cursor-pointer"
                                        onclick="view_branch('delete', ${ row.id }, '${ row.code }', '${ row.name }', '${ row.email ?? '-' }', '${ row.phone ?? '-' }', '${ address }')">
                                    </i>
                                `;
                                return html;
                            }
                        },
                    ],
                    order: [[0, 'desc']],
                    lengthChange: false,
                    scrollX: true,
                    responseive: true,
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            exportOptions: {
                                columns: ':visible(:not(.not-export-col))' // Export all visible columns
                            }
                        }
                    ],
                    language: {
                        paginate: {
                            previous: "<i class='mdi mdi-chevron-left'>",
                            next: "<i class='mdi mdi-chevron-right'>"
                        }
                    },
                    drawCallback: function() {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                        $('.ellipsis-tooltip').tooltip()
                    }
                });
                a.buttons().container().appendTo("#basic-datatable_wrapper .col-md-6:eq(0)")

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        function view_branch(action, id, code, name, email, phone, address, province, city, barangay, latitude, longitude, complete_address){
            empty_fields()
            if(action == 'update'){
                const modal = $('#branch-modal')

                $('#save-branches').data('update-id', id)
                $('#branch-name').val(name)
                $('#branch-code').val(code)
                $('#branch-email').val(email)
                $('#branch-phone').val(phone)
                $('#branch-address').val(address)
                get_province('branch-province', province)
                get_cities('branch-city', province, city)
                $('#branch-city').prop('disabled', false)
                get_barangay('branch-barangay', city, barangay)
                $('#branch-barangay').prop('disabled', false)
                $('#branch-latitude').val(latitude)
                $('#branch-longitude').val(longitude)

                const location = { lat: latitude, lng: longitude }

                setTimeout(() => {
                    branchGoogleMaps(elemetGoogleMaps, complete_address, location)
                    $('#collapseGoogleMaps').addClass('show')
                }, 2000);
                modal.modal('show')
            }
            else{
                const modal = $('#branch-view-modal')
                const checkboxConfimation = $('#delete-confirmation')
                const button = $('#delete-branch')
                button.data('delete-id', id)
                $('.view-code').text(code)
                $('.view-name').text(name)
                $('.view-email').text(email)
                $('.view-phone').text(phone)
                $('.view-address').text(address)
                checkboxConfimation.prop('checked', false)
                modal.modal('show')
            }
        }

        async function save_branch(id) {
            const button = $(`#${ id }`);
            const spinner = $(`#${ id } span#spinner`);
            const buttonTextSpan = $(`#${ id } span#text`);
            const branchFields = {
                id: button.data('update-id'),
                name: $('#branch-name').val(),
                code: $('#branch-code').val(),
                email: $('#branch-email').val(),
                phone: $('#branch-phone').val(),
                address: $('#branch-address').val(),
                province: $('#branch-province').val(),
                city: $('#branch-city').val(),
                barangay: $('#branch-barangay').val(),
                latitude: $('#branch-latitude').val(),
                longitude: $('#branch-longitude').val()
            };

            console.log(branchFields)

            // button.prop('disabled', true);
            // buttonTextSpan.text('');
            // spinner.show();
            // $('.modal-close').prop('disabled', true);

            // try {
            //     const response = await $.ajax({
            //         url: "/admin/branches/create",
            //         type: 'POST',
            //         dataType: 'json',
            //         data: branchFields
            //     });

            //     await table()
            //     setTimeout(function () {
            //         empty_fields();
            //         const message = `Branch <b>${ branchFields.name.toUpperCase() }</b> Successfully Added!`;
            //         showToast('success', message);

            //         button.prop('disabled', false);
            //         buttonTextSpan.text('Save Branch');
            //         spinner.hide();
            //         $('.modal-close').prop('disabled', false);
            //     }, 2000);
            // } catch (error) {
            //     const errors = error.responseJSON.errors;
            //     button.prop('disabled', false);
            //     $('.error-message').text('');

            //     Object.entries(errors).forEach(([field, messages]) => {
            //         $(`#branch-${field}-error`).text(messages[0]);
            //         $('#branch-location-error').text((field == 'latitude' || field == 'longitude') ? 'The Pin Location is required.' : '');
            //     });

            //     buttonTextSpan.text('Save Branch');
            //     spinner.hide();
            //     $('.modal-close').prop('disabled', false);
            // }
        }

        async function delete_branch(id){
            const modal = $('#branch-view-modal')
            const button = $(`#${id}`);
            const spinner = $(`#${id} span#spinner`);
            const buttonTextSpan = $(`#${id} span#text`);
            const checkboxConfimation = $('#delete-confirmation')
            const isConfirm = !checkboxConfimation.prop('checked')
            const branchFields = {
                id: button.data('delete-id')
            };

            if(!isConfirm){
                button.prop('disabled', true);
                buttonTextSpan.text('');
                spinner.show();
                $('.modal-close').prop('disabled', true);
            }

            try {
                if(isConfirm){
                    checkboxConfimation.focus()
                }
                else {
                    const response = await $.ajax({
                        url: "/admin/branches/{$id}",
                        type: 'DELETE',
                        dataType: 'json',
                        data: branchFields
                    });

                    await table()

                    setTimeout(function () {
                        modal.modal('hide')
                        buttonTextSpan.text('Save Branch');
                        spinner.hide();
                        $('.modal-close').prop('disabled', false);
                    }, 2000);
                }
            } catch (error) {
                const errors = error.responseJSON.errors;

                setTimeout(function () {
                    buttonTextSpan.text('Delete Branch');
                    spinner.hide();
                    $('.modal-close').prop('disabled', false);
                }, 2000);
            }
        }

    </script>
@endsection
