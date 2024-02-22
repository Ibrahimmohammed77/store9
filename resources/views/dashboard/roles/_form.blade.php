<div class="form-group row">
    <div class="col-md-12 mx-auto">
        <x-form.input label="Role Name" type="text" name="name" value="{{$role->name}}" id="exampleInputName" />
    </div>
</div>
<fieldset>
    <legend>{{__('Abilities')}}</legend>
    <div class="form-group row">
        <div class="col-md-6">{{__('Name Of Ability')}}</div>
        <div class="col-md-2">
            <label class="form-label">{{__('Allowed')}}</label>
        </div>
         <div class="col-md-2">
            <label class="form-label">{{__('Deny')}}</label>
        </div> 
        <div class="col-md-2">
            <label class="form-label">{{__('Inherit')}}</label>
        </div>
    </div>
    @foreach(app('abilities') as $ability_code =>$ability_name) 
    <div class="form-group row">
        <div class="col-md-6">{{$ability_name}}</div>
        <div class="col-md-2 pr-5">
            <input type="radio" name="abilities[{{$ability_code}}]" value="allow" @checked(($role_ability[$ability_code]??'')=='allow')>
        </div>
         <div class="col-md-2 pr-4">
            <input type="radio" name="abilities[{{$ability_code}}]" value="deny" @checked(($role_ability[$ability_code]??'')=='deny')>
        </div> 
        <div class="col-md-2 pr-4">
            <input type="radio" name="abilities[{{$ability_code}}]" value="inherit" @checked(($role_ability[$ability_code]??'')=='inherit')>
        </div>
    </div>
    @endforeach
</fieldset>
<div class="form-group row">
    <div class="col-md-6">
        <button type="submit" class="btn btn-primary">{{$button_label??'save'}}</button>
    </div>
</div>
