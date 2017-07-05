@extends('layouts.default')
@section('content')
<div class="container">
  <div class="tile is-ancestor has-text-centered padding-top-20px">
    <div class="tile is-parent">
      <div class="tile is-child"></div>
      <div class="tile is-child is-8">
        <h2 class="title is-4">{{__('Select Your Bundle Language')}}</h2>

        {{Form::open(['url' => URL::to('bundle')])}}

        <input checked="checked" class="radio" name="lang" type="radio" value="en" id="bundle"> English <br>

        <input class="radio" name="lang" type="radio" value="es-ES" id="bundle"> Español (Spanish) <br>

        <input class="radio" name="lang" type="radio" value="pt-BR" id="bundle"> Português (Portuguese) <br>

        <input class="radio" name="lang" type="radio" value="de-DE" id="bundle"> Deutsche (German) <br>

        <input class="radio" name="lang" type="radio" value="ru-RU" id="bundle"> ру́сский язы́к (Russian) <br>

        <input class="radio" name="lang" type="radio" value="ja-JP" id="bundle"> 日本語 (Japanese) <br>

        <input class="radio" name="lang" type="radio" value="zn-CN" id="bundle"> 简化字 (Simplified Chinese) <br>

        <button class="button is-primary is-medium margin-top-20px margin-bottom-20px" type="submit">{{__('Begin')}}</button>
        {{Form::close()}}
      </div>
      <div class="tile is-child"></div>
    </div>
  </div>
</div>
@endsection