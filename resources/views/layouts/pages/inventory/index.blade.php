<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Purchase
                    </h4>
                    <button id="open_modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i><span class="btn-icon-add"></span>Add New</button>
                </div>

                <div class="card-body" id="reload">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Supplier Name</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody id="purchase_tbody">

                                @foreach ($data as $key=> $row)
                                    @php
                                        $total = 0;
                                        foreach ($row->purchaseDetails as $key => $value) {
                                            $total += $value->qty * $value->price;
                                        }
                                    @endphp
                                    <tr id="row_purchase_table_{{ $row->id}}">
                                        <td></td>
                                        <td>{{$row->inv_no}}</td>
                                        <td>{{$row->inv_date}}</td>
                                        <td>{{$row->supName->sup_name ?? 'NULL'}}</td>
                                        <td>{{$total}}</td>
                                        <td>
                                            @if($row->status == 0)
                                                <span class="badge light badge-warning">
                                                    <i class="fa fa-circle text-warning mr-1"></i>Pending
                                                </span>
                                            @elseif($row->status == 2)
                                                <span class="badge light badge-danger">
                                                    <i class="fa fa-circle text-danger mr-1"></i>Canceled
                                                </span>
                                            @else
                                                <span class="badge light badge-success">
                                                    <i class="fa fa-circle text-success mr-1"></i>Successful
                                                </span>
                                            @endif
                                        </td>
                                        @if($row->status == 0)
                                        <td style="width:210px;text-align:right">
                                            <button type="button" class="btn btn-sm btn-success p-1 px-2" id="edit_data" data-id="{{ $row->id }}"><i class="fa fa-pencil"></i></i><span class="btn-icon-add"></span>Edit</button>

                                            <button type="button" class="btn btn-sm btn-info p-1 px-2" id="view_data" data-id="{{ $row->id }}"><i class="fa fa-folder-open"></i></i><span class="btn-icon-add"></span>View</button>
                                        </td>
                                        @else
                                            <td style="width:210px;text-align:right">
                                                <button type="button" class="btn btn-sm btn-success p-1 px-2" id="edit_data" data-id="{{ $row->id }}" disabled><i class="fa fa-pencil"></i></i><span class="btn-icon-add"></span>Edit</button>

                                                <button type="button" class="btn btn-sm btn-info p-1 px-2" id="view_data" data-id="{{ $row->id }}"><i class="fa fa-folder-open"></i></i><span class="btn-icon-add"></span>View</button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--=======//Modal Show Data//========-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Create Purchase
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form class="form-valide" data-action="{{route('inv_purchase.store')}}" method="post" enctype="multipart/form-data" id="add-user-form">
                    @csrf
                    <div class="modal-body py-2">
                        <div class="row" id="main-row-data">
                            <input type="hidden" name="pur_id" id="pur_id">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Order No.</label>
                                    <div class="col-md-7">
                                        <label class="col-md-5 col-form-label" id="inv_no">PUR-XXXXX</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Supplier Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <select name="supplier_id" id="supplier_id" class="form-control dropdwon_select" required>
                                            <option selected disabled>--Select--</option>
                                            @foreach($supplier as $row)
                                                <option value="{{ $row->id}}">{{ $row->sup_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Order Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="date" name="inv_date" id="inv_date" class="form-control" value="{{ old('date') ? old('date'):  date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Department Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <select name="dept_id" id="dept_id" class="form-control dropdwon_select" required>
                                            <option selected disabled>--Select--</option>
                                            @foreach($department as $row)
                                                <option value="{{ $row->id}}">{{ $row->dept_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Remarks</label>
                                    <div class="col-md-7">
                                        <textarea name="remarks" id="remarks"  class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Location
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-7">
                                        <select name="loc_id" id="loc_id" class="form-control dropdwon_select" required>
                                            <option selected disabled>--Select--</option>
                                            @foreach($location as $row)
                                                <option value="{{ $row->id}}">{{ $row->location_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!--=====//Table//=====-->
                                <div class="table-responsive">
                                    <table id="items-table" class="table table-bordered mb-0">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th width="20%">Asset Name</th>
                                                <th width="15%">Asset Type</th>
                                                <th width="15%">Asset Details</th>
                                                <th width="10%">Qty</th>
                                                <th width="12%">Price</th>
                                                <th width="15%">Subtotal</th>
                                                <th width="10%" class="text-center table_action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12" id="edit_add_show" style="display: none">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-sm btn-success rounded-0" onClick="addRow(0)"><span class="fa fa-plus mr-1"></span> ADD ITEM</button>
                                </div>
                            </div>
                            <div class="col-md-12 pt-4">
                                <div class="float-right">
                                    <input type="hidden" id="edit_total" value="">
                                    <h6>Total <span style="border: 1px solid #2222;padding: 10px 40px;margin-left:10px" id="total">0.00</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="height:50px">
                        <button type="button" class="btn btn-sm btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary submit_btn">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


</x-app-layout>

<script type="text/javascript">

    var mastSupplierId = $('#supplier_id').html();
    var deptId = $('#dept_id').html();
    var locId = $('#loc_id').html();

    /*=======//Show Modal//=========*/
    $(document).on('click','#open_modal',function(){

        var tableBody = $('#table-body');
        tableBody.empty();
        addRow(0);

        //--Dropdwon Search Fix
        $('.dropdwon_select').each(function () {
            $(this).select2({
                dropdownParent: $(this).parent()
            });
        });

        $("#pur_id").val('');
        $('#inv_no').prop("disabled", false);
        $("#inv_date").prop("disabled", false);
        $('#remarks').prop("disabled", false);
        $('#supplier_id').prop("disabled", false);
        $('#supplier_id').html(mastSupplierId);
        $('#dep_id').prop("disabled", false);
        $('#dep_id').html(deptId);
        $('#loc_id').prop("disabled", false);
        $('#loc_id').html(locId);
        $('#total').text("0.00");

        $(".modal-title").html('Create Purchase');
        $(".bd-example-modal-lg").modal('show');
        $(".table_action").show();
        $(".submit_btn").show();
    });

    /*=======//Save Data //=========*/
    $(document).ready(function(){
        var form = '#add-user-form';
        $(form).on('submit', function(event){
            event.preventDefault();
            var url = $(this).attr('data-action');
            var allSubValuesNotNull = true;
            $('.val_part_number').each(function() {
                var value = $(this).val();
                if (value === null || value === '') {
                    allSubValuesNotNull = false;
                    return false;
                }
            });
            $('.val_quantity').each(function() {
                var value = $(this).val();
                if (value === null || value === '') {
                    allSubValuesNotNull = false;
                    return false;
                }
            });
            $('.val_price').each(function() {
                var value = $(this).val();
                if (value === null || value === '') {
                    allSubValuesNotNull = false;
                    return false;
                }
            });
            if (allSubValuesNotNull) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response)
                    {
                        $(form).trigger("reset");
                        swal("Success Message Title", "Well done, you pressed a button", "success")
                        $(".bd-example-modal-lg").modal('hide');
                        var storePurchase = response.storePurchase;

                        var i = 0;++i;
                        var row = '<tr id="row_purchase_table_'+ storePurchase.id + '" role="row" class="odd">';
                        row += '<td></td>';
                        row += '<td>' + storePurchase.inv_no + '</td>';
                        row += '<td>' + storePurchase.inv_date + '</td>';
                        row += '<td>' + response.supplier.sup_name + '</td>';
                        row += '<td>' + response.total + '</td>';
                        row += '<td>';
                        if(storePurchase.status == 0)
                            row += '<span class="badge light badge-warning"><i class="fa fa-circle text-warning mr-1"></i>Pending</span>';
                        else if(storePurchase.status == 1)
                            row += '<span class="badge light badge-success"><i class="fa fa-circle text-success mr-1"></i>Successful</span>';
                        else if(storePurchase.status == 2)
                            row += '<span class="badge light badge-danger"><i class="fa fa-circle text-danger mr-1"></i>Canceled</span>';

                        row += '</td>';
                        row += '<td class="d-flex"><button type="button" class="btn btn-sm btn-success p-1 px-2 mr-1" id="edit_data" data-id="'+storePurchase.id+'"><i class="fa fa-pencil"></i></i><span class="btn-icon-add"></span>Edit</button><button type="button" class="btn btn-sm btn-info p-1 px-2" id="view_data" data-id="'+storePurchase.id+'"><i class="fa fa-folder-open"></i></i><span class="btn-icon-add"></span>View</button></td>';

                        if($("#pur_id").val()){
                            $("#row_purchase_table_" + storePurchase.id).replaceWith(row);
                        }else{
                            $("#purchase_tbody").prepend(row);
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li style="color:red">' + value + '</li>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: '<ul>' + errorHtml + '</ul>',
                            text: 'All input values are not null or empty.',
                        });
                    }
                });
            } else {
                swal("Error!", "All input values are not null or empty.", "error");
            }
        });
    });

    /*========//Edit Data//=========*/
    $(document).on('click', '#edit_data', function(){
        var id = $(this).data('id');

        $.ajax({
            url:'{{ route('inv_purchase_edit')}}',
            method:'GET',
            dataType:"JSON",
            data:{id:id},
            success:function(response){
                showData(response, 1);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    /*========//View Data//=========*/
    $(document).on('click', '#view_data', function(){
        var id = $(this).data('id');

        $.ajax({
            url:'{{ route('inv_purchase_edit')}}',
            method:'GET',
            dataType:"JSON",
            data:{id:id},
            success:function(response){
                showData(response, 2);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    function showData(response, check) {
        $(".bd-example-modal-lg").modal('show');
        $(".modal-footer").show();

        //--Get Master Data
        var data = response.data;

        $("#pur_id").val(data.id);
        $('#inv_no').html(data.inv_no);
        $("#inv_date").val(data.inv_date);
        $('#remarks').html(data.remarks);

        //--Get Supplier Data
        var suppliers = response.suppliers;
        var supplier_dr = $('#supplier_id');
        supplier_dr.empty();
        supplier_dr.append('<option>Select a Supplier</option>');
        $.each(suppliers, function(index, option) {
            var selected = (option.id == data.supplier_id) ? 'selected' : '';
            // alert('hi');
            supplier_dr.append('<option value="' + option.id + '" ' + selected + '>' + option.sup_name + '</option>');

            // alert(option.sup_name);
        });

        //--Departments--

        var departments = response.departments;
        var department_dr = $('#dept_id');
        department_dr.empty();
        department_dr.append('<option>Select a department</option>');
        $.each(departments, function(index, option) {
            var selected = (option.id == data.dept_id) ? 'selected' : '';
            // alert(option.dept_name);
            department_dr.append('<option value="' + option.id + '" ' + selected + ' >' + option.dept_name + '</option>');
        });

        //-Location--
        var locations = response.locations;
        var location_dr = $('#loc_id');
        location_dr.empty();
        location_dr.append('<option>Select a Supplier</option>');
        $.each(locations, function(index, option) {
            var selected = (option.id == data.loc_id) ? 'selected' : '';
            // alert('hi');
            location_dr.append('<option value="' + option.id + '" ' + selected + '>' + option.location_name + '</option>');

            // alert(option.sup_name);
        });

        if(check == 1){
            $(".modal-title").html('Create Purchase');

            $("#pur_id").prop("disabled", false);
            $('#inv_no').prop("disabled", false);
            $("#inv_date").prop("disabled", false);
            $('#remarks').prop("disabled", false);
            $('#supplier_id').prop("disabled", false);
            $('#dept_id').prop("disabled", false);
            $('#loc_id').prop("disabled", false);


            $(".table_action").show();
            $('.submit_btn').show();
        }else{
            $(".modal-title").html('Create Purchase');

            $("#pur_id").prop("disabled", true);
            $('#inv_no').prop("disabled", true);
            $("#inv_date").prop("disabled", true);
            $('#remarks').prop("disabled", true);
            $('#supplier_id').prop("disabled", true);
            $('#dept_id').prop("disabled", true);
            $('#loc_id').prop("disabled", true);

            $('.table_action').hide();
            $('.submit_btn').hide();
            $('#edit_add_show').hide();
        }

        //--Table Purchase Details
        var tableBody = $('#table-body');
        tableBody.empty();
        var purchaseDetails = response.purchase_details;
        var total = 0;
        var i = 0;
        if(check == 1){ //Edit - 1
            $.each(purchaseDetails, function(index, item) {
                var subtotal = item.qty * item.price;
                var newRow = $('<tr id="row_todo_'+ item.id + '">' +
                    '<input type="hidden" name="editFile['+i+'][id]" id="salesDetailsId" value="' + item.id + '">' +
                    '<td>'+
                        '<select id="item_category" class="form-control dropdwon_select val_item_category">' +
                        '<option selected disabled>--Select--</option>' +
                        '@foreach($group as $data)' +
                            '<option value="{{ $data->id }}" data-part_name="{{ $data->group_name }}" ' + ('{{ $data->id }}' == item.item_groups_id ? 'selected' : '') + '>' + '{{ $data->group_name }}' + '</option>' +
                        '@endforeach' +
                        '</select>' +
                    '</td>' +
                    '<td><select id="partNumber" name="editFile['+i+'][item_id]" class="form-control dropdwon_select val_part_number"></select></td>' +
                    '<td><select id="assetName" name="" class="form-control dropdwon_select"><option value="' + item.asset_name + '">' + item.asset_name + '</option></select></td>' +
                    '<td><input type="number" name="editFile['+i+'][qty]" id="" class="form-control quantity val_quantity" placeholder="0.00" value="'+ item.qty +'"></td>' +
                    '<td><input type="number" name="editFile['+i+'][price]" id="" class="form-control price val_price" placeholder="0.00" value="'+ item.price +'"></td>' +
                    '<td class="subtotal">'+ subtotal +'</td>' +
                    '<td class="text-center countTdData">' +
                        '<button type="button" title="Add New" class="btn btn-icon btn-outline-warning border-0 btn-xs edit_add_hide" onClick="addRow(0)"><span class="fa fa-plus"></span></button>' +
                        '<button type="button" title="Remove" class="btn btn-icon btn-outline-danger btn-xs border-0" id="delete_data" data-id="' + item.id +'"><span class="fa fa-trash"></span></button>' +
                    '</td>'+
                '</tr>');

                if ($("#id").val()) {
                    $("#row_todo_" + item.id).replaceWith(newRow);
                } else {
                    tableBody.append(newRow);
                }

                var currentRow = $(newRow);
                var partNumberSelect = currentRow.find('.val_part_number');
                $.ajax({
                    url: '{{ route('edit-part-id')}}',
                    method: 'GET',
                    dataType: 'JSON',
                    data: { 'part_id': item.item_types_id },
                    success: function(data) {
                        // Clear existing options
                        partNumberSelect.empty();

                        // Add a default option
                        partNumberSelect.append('<option value="" selected>--Select--</option>');

                        // Populate options based on the received data
                        $.each(data, function(index, option) {
                            var selected = (option.id == item.item_types_id) ? 'selected' : '';
                            partNumberSelect.append('<option value="' + option.id + '" ' + selected + '>' + option.type_name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Failed to fetch data.');
                    }
                });

                i++;
                $(this).find('.subtotal').text(subtotal.toFixed(2));
                total += subtotal;
            });
            $('#total').text(total.toFixed(2));

            var rowCount = parseInt($('#items-table tbody tr').length);
            var countTrData = parseInt($('#items-table tbody tr .countTdData').length);
            if(rowCount < 0 || countTrData < 1 ){
                $('#edit_add_show').show();
            }else{
                $('#edit_add_show').hide();
            }
        }
        if(check == 2){ //View - 2
            $.each(purchaseDetails, function(index, item) {
                var subtotal = item.qty * item.price;
                var row = '<tr id="row_todo_'+ item.id + '">';
                row += '<td>' + item.group_name + '</td>';
                row += '<td>' + item.type_name + '</td>';
                row += '<td>' + item.asset_name + '</td>';
                row += '<td>' + item.qty + '</td>';
                row += '<td>' + item.price + '</td>';
                row += '<td>'+ subtotal +'</td>';
                row += '</tr>';
                tableBody.prepend(row);

                $(this).find('.subtotal').text(subtotal.toFixed(2));
                total += subtotal;
            });
            $('#total').text(total.toFixed(2));
        }
    }

    /*========//Delete Data//========*/
    $(document).ready(function(){
        $.ajaxSetup({
            headers:{
                'x-csrf-token' : $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    $("body").on('click','#delete_data',function(){
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Place your delete code here
                $.ajax({
                    url: "{{ url('inv_purchase/destroy')}}" + '/' + id,
                    method: 'DELETE',
                    type: 'DELETE',
                    success: function(response) {
                        toastr.success("Record deleted successfully!");
                        $("#row_todo_" + id).remove();
                        $('#table-body').closest('tr').remove();
                        updateSubtotal(0);

                        var countTrData = parseInt($('#items-table tbody tr .countTdData').length);
                        if(countTrData < 1 ){
                            $(".bd-example-modal-lg").modal('hide');
                            deleteMasterData();
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                // User clicked "No" button, do nothing
                swal("Your data is safe!", {
                    icon: "success",
                });
            }
        });

    });
    function deleteMasterData(){
        var id = $('#pur_id').val();
        $.ajax({
            url:'{{ route('getDelete-master-purchase')}}',
            method:'GET',
            dataType:"JSON",
            data:{'id':id},
            success:function(response){
                swal("Your data save successfully", "Well done, you pressed a button", "success")
                    .then(function() {
                        location.reload();
                    });
            },
            error:function(){
                alert('Fail');
            }
        });
    }
</script>

<script type="text/javascript">
    //======Add ROW
    var count = 0;
    $("#items-table").on("click", ".add-row", function() {
        var allValuesNotNull = true;
        $('.val_part_number').each(function() {
            var value = $(this).val();
            if (value === null || value === '') {
                allValuesNotNull = false;
                return false;
            }
        });
        $('.val_quantity').each(function() {
            var value = $(this).val();
            if (value === null || value === '') {
                allValuesNotNull = false;
                return false;
            }
        });
        $('.val_price').each(function() {
            var value = $(this).val();
            if (value === null || value === '') {
                allValuesNotNull = false;
                return false;
            }
        });
        if (allValuesNotNull) {
            ++count;
            addRow(count);
        } else {
            swal("Error!", "All input values are not null or empty.", "error");
        }
    });
    function addRow(i){
        var newRow = $('<tr>' +
            '<td>'+
                '<select id="item_category" class="form-control dropdwon_select val_item_category">' +
                '<option selected disabled>--Select--</option>' +
                '@foreach($group as $data)' +
                    '<option value="{{ $data->id}}">{{ $data->group_name}}</option>' +
                    '@endforeach' +
                '</select>' +
            '</td>' +
            '<td><select id="partNumber" name="moreFile['+i+'][item_id]" class="form-control dropdwon_select val_part_number"></select></td>' +
            '<td><select id="assetName" class="form-control dropdwon_select"></select></td>' +
            '<td><input type="number" name="moreFile['+i+'][qty]" id="" class="form-control quantity val_quantity" placeholder="0"></td>' +
            '<td><input type="number" name="moreFile['+i+'][price]" id="" class="form-control price val_price" placeholder="0.00"></td>' +
            '<td class="subtotal">0.00</td>' +
            '<td class="text-center">' +
                '<button type="button" title="Add New" class="btn btn-icon btn-outline-warning border-0 btn-xs add-row"><span class="fa fa-plus"></span></button>' +
                '<button type="button" title="Remove" class="btn btn-icon btn-outline-danger btn-xs border-0 remove-row"><span class="fa fa-trash"></span></button>' +
            '</td>'+
        '</tr>');


        $('.edit_add_hide').hide();
        var rowCount = parseInt($('#items-table tbody tr').length);
        var countTrData = parseInt($('#items-table tbody tr .countTdData').length);
        if(rowCount < 0){
            $('#edit_add_show').show();
        }else{
            $('#edit_add_show').hide();
        }


        $('#items-table tbody').append(newRow);
        //--Dropdwon Search Fix
        newRow.find('.dropdwon_select').each(function () {
            $(this).select2({
                dropdownParent: $(this).parent()
            });
        });
    }

    //======Remove ROW
    $('#items-table').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateSubtotal(0);

        var rowCount = parseInt($('#items-table tbody tr td .add-row').length);
        var countTrData = parseInt($('#items-table tbody tr .countTdData').length);
        if(rowCount < 1 || countTrData < 1 ){
            $('#edit_add_show').show();
        }else{
            $('#edit_add_show').hide();
        }
    });
    //======Total Count
    $('#items-table').on('input', '.quantity, .price', function() {
        updateSubtotal(0);
    });
    function updateSubtotal(update_subTotal) {
        var total = 0;
        $('#items-table tbody tr').each(function() {
            var quantity = parseFloat($(this).find('.quantity').val()) || 0;
            var price = parseFloat($(this).find('.price').val()) || 0;
            var subtotal = quantity * price;
            $(this).find('.subtotal').text(subtotal.toFixed(2));
            total += subtotal;
        });
        var update_total = total - update_subTotal;
        $('#total').text(update_total.toFixed(2));
    }
</script>
<script type="text/javascript">
    //======Get Item Group All Data
    $(document).on('change','#item_category',function(){
        var partId = $(this).val();
        var currentRow = $(this).closest("tr");
        //alert('hello');
        $.ajax({
            url:'{{ route('get-part-id')}}',
            method:'GET',
            dataType:"html",
            data:{'part_id':partId},
            success:function(data){
                console.log(data)
                currentRow.find('#partNumber').html(data);
            },
            error:function(){
                alert('Fail');
            }
        });
    });
    //======Show Single Row Data
    $(document).on('change','#partNumber', function(){
        var partNumber_id = $(this).val();
        // alert(partNumber_id);
        var currentRows = $(this).closest("tr");

        $.ajax({
            url:'{{ route('get-part-number')}}',
            method:'GET',
            dataType:"HTML",
            data:{'part_id':partNumber_id},
            success:function(data){
                console.log(data)
                currentRows.find('#assetName').html(data);
            }
        });
    });
    //======Duplicates Part Number Validation
    $(document).on('change','.val_part_number', function() {
        var dropdownValues = $('.val_part_number').map(function() {
            return $(this).val();
        }).get();

        var hasDuplicates = new Set(dropdownValues).size !== dropdownValues.length;
        if (hasDuplicates) {
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Values',
                text: 'Duplicate values are not allowed in the partNumber dropdown.',
            });
            //--Reset Option
            var $currentRow = $(this).closest('tr');
            var itemCategoryValue = $currentRow.find('.val_item_category').val();
            var currentRow = $(this).closest("tr");
            $.ajax({
                url:'{{ route('get-part-id')}}',
                method:'GET',
                dataType:"html",
                data:{'part_id':itemCategoryValue},
                success:function(data){
                    console.log(data)
                    alert('purnima');
                    currentRow.find('#partNumber').val(data);
                },
                error:function(){
                    alert('Fail');
                }
            });
        }
    });
    //======Validation Message
    @if(Session::has('messege'))
        var type="{{Session::get('alert-type','info')}}"
        switch(type){
            case 'save':
                swal("Success Message Title", "Well done, you pressed a button", "success");
                break;
            case 'fail':
                swal("Error!", "{{ Session::get('messege') }}", "error");
                $('.bd-example-modal-lg').modal('show');
            break;
        }
    @endif
</script>



