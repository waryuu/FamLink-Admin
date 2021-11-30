@extends('layouts.base')
@section('title', 'Admin')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header"><h4 class="page-title">Admin</h4></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add Row</h4>
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                                <i class="fa fa-plus"></i>
                                Add Row
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                New
                                            </span>
                                            <span class="fw-light">
                                                Row
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="exampleValidation">
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group form-show-validation row">
                                                    <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Name <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="username" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Username <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="username-addon">@</span>
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="username-addon" id="username" name="username" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Email Address <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="email" class="form-control" id="email" placeholder="Enter Email" required>
                                                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Password <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="confirmpassword" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Confirm Password <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required>
                                                    </div>
                                                </div>
                                                <div class="separator-solid"></div>
                                                <div class="form-group form-show-validation row">
                                                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Gender <span class="required-label">*</span></label>
                                                    <div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="male" name="gender" class="custom-control-input">
                                                            <label class="custom-control-label" for="male">Male</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="female" name="gender" class="custom-control-input">
                                                            <label class="custom-control-label" for="female">Female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="birth" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Birth <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="birth" name="birth" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="fa fa-calendar-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-show-validation row">
                                                    <label for="birth" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">State <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <div class="select2-input">
                                                            <select id="state" name="state" class="form-control" required>
                                                                <option value="">&nbsp;</option>
                                                                <optgroup label="Alaskan/Hawaiian Time Zone">
                                                                    <option value="AK">Alaska</option>
                                                                    <option value="HI">Hawaii</option>
                                                                </optgroup>
                                                                <optgroup label="Pacific Time Zone">
                                                                    <option value="CA">California</option>
                                                                    <option value="NV" >Nevada</option>
                                                                    <option value="OR">Oregon</option>
                                                                    <option value="WA">Washington</option>
                                                                </optgroup>
                                                                <optgroup label="Mountain Time Zone">
                                                                    <option value="AZ">Arizona</option>
                                                                    <option value="CO">Colorado</option>
                                                                    <option value="ID">Idaho</option>
                                                                    <option value="MT">Montana</option>
                                                                    <option value="NE">Nebraska</option>
                                                                    <option value="NM">New Mexico</option>
                                                                    <option value="ND">North Dakota</option>
                                                                    <option value="UT">Utah</option>
                                                                    <option value="WY">Wyoming</option>
                                                                </optgroup>
                                                                <optgroup label="Central Time Zone">
                                                                    <option value="AL">Alabama</option>
                                                                    <option value="AR">Arkansas</option>
                                                                    <option value="IL">Illinois</option>
                                                                    <option value="IA">Iowa</option>
                                                                    <option value="KS">Kansas</option>
                                                                    <option value="KY">Kentucky</option>
                                                                    <option value="LA">Louisiana</option>
                                                                    <option value="MN">Minnesota</option>
                                                                    <option value="MS">Mississippi</option>
                                                                    <option value="MO">Missouri</option>
                                                                    <option value="OK">Oklahoma</option>
                                                                    <option value="SD">South Dakota</option>
                                                                    <option value="TX">Texas</option>
                                                                    <option value="TN">Tennessee</option>
                                                                    <option value="WI">Wisconsin</option>
                                                                </optgroup>
                                                                <optgroup label="Eastern Time Zone">
                                                                    <option value="CT">Connecticut</option>
                                                                    <option value="DE">Delaware</option>
                                                                    <option value="FL">Florida</option>
                                                                    <option value="GA">Georgia</option>
                                                                    <option value="IN">Indiana</option>
                                                                    <option value="ME">Maine</option>
                                                                    <option value="MD">Maryland</option>
                                                                    <option value="MA">Massachusetts</option>
                                                                    <option value="MI">Michigan</option>
                                                                    <option value="NH">New Hampshire</option>
                                                                    <option value="NJ">New Jersey</option>
                                                                    <option value="NY">New York</option>
                                                                    <option value="NC">North Carolina</option>
                                                                    <option value="OH">Ohio</option>
                                                                    <option value="PA">Pennsylvania</option>
                                                                    <option value="RI">Rhode Island</option>
                                                                    <option value="SC">South Carolina</option>
                                                                    <option value="VT">Vermont</option>
                                                                    <option value="VA">Virginia</option>
                                                                    <option value="WV">West Virginia</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="separator-solid"></div>
                                                <div class="form-group form-show-validation row">
                                                    <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Upload Image <span class="required-label">*</span></label>
                                                    <div class="col-12">
                                                        <div class="input-file input-file-image">
                                                            <img class="img-upload-preview img-circle" width="100" height="100" src="http://placehold.it/100x100" alt="preview">
                                                            <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" required >
                                                            <label for="uploadImg" class="btn btn-primary btn-round btn-lg"><i class="fa fa-file-image"></i> Upload a Image</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <div class="row">
                                                        <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2">Agree <span class="required-label">*</span></label>
                                                        <div class="col-lg-4 col-md-9 col-sm-8 d-flex align-items-center">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="agree" name="agree" required>
                                                                <label class="custom-control-label" for="agree">Agree with terms and conditions</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" id="addRowButton" class="btn btn-primary">Add</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table_view" class="display table table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    var base_endpoint = "/menu/"
    var table_id = '#table_view';
    var table = null;

    function initDataTableLoad(view_id, endpoint) {
        table = $(view_id).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": endpoint,
            "columns" : [
            {
                data: 'id',
                name: 'id',
                render : function(data, type, row) {
                    return '<strong class=" col-red" style="font-size: 12px">'+row['id']+'</strong>';
                }
            },
            {
                data: 'name',
                name: 'name',
                render : function(data, type, row) {
                    return '<strong class=" col-red" style="font-size: 12px">'+row['name']+'</strong>';
                }
            },
            {
                data: 'created_at',
                name: 'created_at',
                render : function(data, type, row) {
                    return '<strong class=" col-red" style="font-size: 12px">'+row['created_at']+'</strong>';
                }
            },
            {
                data: 'id',
                name: 'id',
                render : function(data, type, row) {
                    return '<div class="form-button-action"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus" onclick="deleteAlert('+row['id']+')"><i class="fa fa-times"></i></button></div>';
                }
            },
            ],
        });
    }

    function deleteAlert(id) {
        console.log(id);
        swal({
            title: 'Peringatan',
            text: "Apakah anda yakin akan menghapus data?",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Ya',
                    className : 'btn btn-success'
                },
                cancel: {
                    text : 'Tidak',
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                {
                    url: base_endpoint+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (){
                        swal({
                            title: 'Terhapus!',
                            icon: 'success',
                            text: 'Berhasil menghapus data',
                            type: 'success',
                            cancel: false,
                            buttons : {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            }
                        }).then((Delete) => {
                            $(table_id).DataTable().ajax.reload();
                        });


                    }
                });
            } else {
                swal.close();
            }
        });
    }

    function initFomrUI() {
        $('#birth').datetimepicker({
            format: 'MM/DD/YYYY'
        });

        $('#state').select2({
            theme: "bootstrap"
        });

        /* validate */

        // validation when select change
        $("#state").change(function(){
            $(this).valid();
        })

        // validation when inputfile change
        $("#uploadImg").on("change", function(){
            $(this).parent('form').validate();
        })

        $("#exampleValidation").validate({
            validClass: "success",
            rules: {
                gender: {required: true},
                confirmpassword: {
                    equalTo: "#password"
                },
                birth: {
                    date: true
                },
                uploadImg: {
                    required: true,
                },
            },
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
        });
    }

    $(document).ready(function() {
        initDataTableLoad(table_id, base_endpoint+'create')
        initFomrUI();
    });

</script>
@endsection
