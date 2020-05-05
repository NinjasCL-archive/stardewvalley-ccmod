@extends('layouts.default')
@section('content')
<div class="container content">
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
		
		<input class="radio" name="lang" type="radio" value="it-It" id="bundle"> Italiano (Italian) <br>
		
		<input class="radio" name="lang" type="radio" value="fr-FR" id="bundle"> Français (French) <br>
		
		<input class="radio" name="lang" type="radio" value="tr-TR" id="bundle"> Türkçe (Turkish) <br>
		
		<input class="radio" name="lang" type="radio" value="hu-HU" id="bundle"> magyar nyelv (Hungarian) <br>

        <input class="radio" name="lang" type="radio" value="ru-RU" id="bundle"> ру́сский язы́к (Russian) <br>

        <input class="radio" name="lang" type="radio" value="ja-JP" id="bundle"> 日本語 (Japanese) <br>

        <input class="radio" name="lang" type="radio" value="zn-CN" id="bundle"> 简化字 (Simplified Chinese) <br>
		
		<input class="radio" name="lang" type="radio" value="ko-KR" id="bundle"> 한국어/韓國語 (Korean) <br>
		

        <button class="button is-primary is-medium margin-top-20px margin-bottom-20px" type="submit">{{__('Begin')}}</button>
		
		<p>
		<strong>{{__('It will take a while to load. Please be patient.')}}</strong>
		</p>
        {{Form::close()}}
      </div>
      <div class="tile is-child"></div>
    </div>
  </div>
</div>
@endsection