@extends('layouts.admin.template')
@section('title', 'Profile')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">Profile </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form id="form_edit" action="{{ route('admin.profile.update') }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Profile User</h4>
                                </div>
                            </div>
                            @include('admin.profile.form')

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const user = @json($user);

        $('#form_edit').find('input[name="name"]').val(user.name);
        $('#form_edit').find('input[name="username"]').val(user.username);
        $('#form_edit').find('input[name="email"]').val(user.email);
        $('#form_edit').find('select[name="role_id"]').val(user.role_id).change();
        $('#form_edit').find('select[name="jenis_kelamin"]').val(user.jenis_kelamin).change();
        $('#form_edit').find('input[name="password"]').attr('required', false);
        $('#form_edit input[name="password"]').closest('.input-block').find('.login-danger').remove();
        $('#form_edit').find('input[name="password_confirmation"]').attr('required', false);
        $('#form_edit input[name="password_confirmation"]').closest('.input-block').find('.login-danger').remove();
        if (user.avatar) {
            $('#preview').css('display', 'block');
            $('#preview').attr('src', "{{ asset('avatar/' . $user->avatar) }}");
        }
    </script>
@endpush
