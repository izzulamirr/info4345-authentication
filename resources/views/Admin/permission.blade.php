@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Role Permission Management</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.permissions.update') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Role</th>
                    @foreach($permissions as $perm)
                        <th>{{ $perm }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->RoleName }}</td>
                        @foreach($permissions as $perm)
                            <td>
                                <input type="checkbox"
                                    name="permissions[{{ $role->RoleID }}][]"
                                    value="{{ $perm }}"
                                    {{ \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', $perm)->exists() ? 'checked' : '' }}>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update Permissions</button>
    </form>
</div>
@endsection