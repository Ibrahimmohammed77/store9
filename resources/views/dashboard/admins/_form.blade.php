<div class="form-group row">
    <div class="col-md-12 mx-auto">
        <x-form.input label="Admin Name" type="text" name="name" value="{{$admin->name}}" id="exampleInputName" />
        <x-form.input label="Admin Email" type="email" name="email" value="{{$admin->email}}" id="exampleInputEmail" />
    </div>
</div>
<fieldset>
    <legend>{{__('Admins')}}</legend>
   @php $i=0;@endphp
    @foreach($roles as $role) 
    <div class="form-group row">
        <div class="col-md-6">{{$role->name}}</div>
        <div class="col-md-2 pr-5">
            <input type="radio" name="roles[]" value="{{$role->id}}" @if(isset($admin_roles) && ($admin_roles!==[] && count($admin_roles)>$i)) @checked($role->id==$admin_roles[$i++]) @endif>
        </div>
         {{-- <div class="col-md-2 pr-4">
            <input type="radio" name="roles[{{$role_id}}]" value="deny" @checked($role_id=='deny')>
        </div>  --}}
    </div>
    @endforeach
</fieldset>
<div class="form-group row">
    <div class="col-md-6">
        <button type="submit" class="btn btn-primary">{{$button_label??'save'}}</button>
    </div>
</div>
