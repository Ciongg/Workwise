@props(['name'])

@error($name){
    <p class="text-red text-sm mt-4">{{$message}}</p>
}
@enderror