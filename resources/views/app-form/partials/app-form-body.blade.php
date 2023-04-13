<div>
    <x-input-label for="app_name" :value="__('Name')" />
    <x-text-input name="app_name" type="text"  class="mt-1 block w-full" :value="old('app_name')"/>
    <x-input-error :messages="$errors->appform->first('app_name')" class="mt-2" />        
</div>

<div>
    <x-input-label for="description" :value="__('Description')" />
    <textarea name="description" type="text" placeholder="Describe the situation"   maxlength="200" class=" border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1 -mb-1">{{ old('description') }}</textarea>  
    <x-input-error :messages="$errors->appform->first('description')" class="mt-2" /> 
</div>

<div>
    <x-input-label for="type" :value="__('Type')" />     
    <select  id="type" name="type" required focus onchange="showHideTextarea()" class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
        <option value="1">Usterka</option>        
        <option value="2">Informacja</option>    
        <option value="3">Zapytanie</option>
    </select>
    <x-input-error :messages="$errors->appform->first('type')" class="mt-2" /> 
</div>

<div style="display: none;" class="" id="placeTxtAreaDiv">
    <x-input-label for="place" :value="__('Place')" />
    <textarea name="place" type="text" maxlength="50" placeholder="Describe the place where it happened"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1 -mb-1">{{ old('place') }}</textarea>
    <x-input-error :messages="$errors->appform->first('place')" class="mt-2" /> 
</div>
