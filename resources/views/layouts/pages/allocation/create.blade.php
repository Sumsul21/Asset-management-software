<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- card header -->
                <div class="card-header">
                    <h4 class="card-title">Create Allocation Information</h4>
                    <a href="{{ route('allocation.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-reply"></i><span class="btn-icon-add"></span>Back</a>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        @if (session()->has('success'))
                            <strong class="text-success">{{ session()->get('success') }}</strong>
                        @endif

                        <form class="form-valide" action="{{ route('allocation.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label class="row-lg col-form-label">Asset Code
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="row-lg">
                                            <select class="form-control dropdwon_select" id="asset_code" name="asset_transections_id" required>
                                                <option selected disabled value="">Please Select Asset Code</option>
                                                @foreach ($ast_code as $row)
                                                    <option value="{{$row->id}}" data-end-date="{{$row->end_date}}">{{$row->asset_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label class="row-lg col-form-label">End Date</label>
                                        <div class="row-lg">
                                            <input type="date" name="" id="end_date" class="form-control placeholder="" value="" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label class="row-lg col-form-label">Sang Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="row-lg">
                                            <input type="date" name="sang_date" id="" class="form-control @error('date_of_birth') is-invalid @enderror" placeholder="" value="{{old('date_of_birth')}}" />
                                            @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label class="row-lg col-form-label">Allocation To</label>
                                        <span class="text-danger">*</span>
                                        <div class="row-lg">
                                            <select class="form-control dropdwon_select" id="employee" name="employees_id" required>
                                                <option selected disabled value="">Please Select Employee Name</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->emp_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label class="row-lg col-form-label">Allocation Department</label>
                                        <span class="text-danger">*</span>
                                        <div class="row-lg">
                                            <input type="text" id="department" class="form-control text-capitalize @error('department') is-invalid @enderror" name="dept_id" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label class="row-lg col-form-label">Allocation Location</label>
                                        <span class="text-danger">*</span>
                                        <div class="row-lg">
                                            <input type="text" id="location" class="form-control text-capitalize @error('location') is-invalid @enderror" name="loc_id" value="{{old('location')}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="form-group col">
                                        <label for="" class="row-lg col-form-label">Remarks </label>
                                        <div class="row-lg">
                                            <textarea class="text form-control" id="" name="remarks" rows="2"></textarea>
                                            @error('remarks')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <input type="hidden" id="status" name="status" value="1">
                                </div>

                                <!-- submit button -->
                                <div class="col-xl-12">
                                    <div class="col-lg">
                                        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('.dropdwon_select').select2();
    });
</script>


<script>
    $(document).ready(function() {
        $('#asset_code').change(function(){
            var selectedDate = $(this).find(':selected').data('end-date');
            $('#end_date').val(selectedDate);
        });
    });
</script>

<script>
    $(document).on('change','#employee', function(){
        var employeeId = $(this).val();

        $.ajax({
            url: '{{ route('get-employee-details')}}',
            method: 'GET',
            dataType: "JSON",
            data: {'employee_id': employeeId},
            success:function(data){
                console.log(data);

                $('#department').val(data.dept_name.dept_name);
                $('#location').val(data.loc_name.location_name);
            }
        });
    });
</script>

