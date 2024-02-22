<div class="form-group row">
    <div class="col-md-12 mx-auto">
        <x-form.input label="User Name" type="text" name="name" value="{{$user->name}}" id="exampleInputName" />
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
            <input type="radio" name="abilities[{{$ability_code}}]" value="allow" @checked(($user_ability[$ability_code]??'')=='allow')>
        </div>
         <div class="col-md-2 pr-4">
            <input type="radio" name="abilities[{{$ability_code}}]" value="deny" @checked(($user_ability[$ability_code]??'')=='deny')>
        </div> 
        <div class="col-md-2 pr-4">
            <input type="radio" name="abilities[{{$ability_code}}]" value="inherit" @checked(($user_ability[$ability_code]??'')=='inherit')>
        </div>
    </div>
    @endforeach
</fieldset>
<div class="form-group row">
    <div class="col-md-6">
        <button type="submit" class="btn btn-primary">{{$button_label??'save'}}</button>
    </div>
</div>
