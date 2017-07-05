@extends('layouts.default')
@section('scripts')
  
  <link rel="stylesheet" type="text/css" href="{{asset('bower_components/chosen/chosen.css')}}">
  <script src="{{asset('bower_components/chosen/chosen.jquery.js')}}"></script>

  <script>
    $(document).ready(function()
    {
        $('.chosen-select').chosen();

        var bundles = {!! $bundles_json !!};
        var items = {!! $items_json !!};

        var helpers = {
          id : function(object) {
            return parseInt(object.attr('data-bundle-index'));
          },
          bundle : function(object) {
              var id = helpers.id(object);
              var bundle = bundles[id];
              return bundle;
          },
          selected : {
            option : function(select) {
              return select.find('option:selected');
            },
            bundle : function(select) {
              var option = helpers.selected.option(select);
              var bundle = helpers.bundle(option);
              return bundle;
            }
          },
          item : function(object) {
            var id = object.attr('data-index-loop');
            var item = items[id];
            return item;
          },

          update : {
            bundle: function(bundle, object) {
              var id = helpers.id(object);
              bundles[id] = bundle;
              
              console.log('Updated');
              console.log(bundles[id]);
            }
          },
          number : function(value) {
            
            if(value < 0) {
              value = 0;
            }

            return Math.abs(parseInt(value));
          },
          requirement : {
            id : function(object) {
              return object.attr('data-index');
            },
            get : function(bundle, object) {
              var id = helpers.requirement.id(object);
              return bundle.requirements[id];
            }
          },
          quality : {
              name : function(object) {
                return object.attr('data-quality-name');
              },
              value : function(object) {
                return helpers.number(object.attr('data-quality-value'));
              }
          }
        };

        $('.bundle-input-name').on('propertychange change click keyup input paste blur', function(e)
        {
          if($(this).val().length > 0)
          {
            var bundle = helpers.bundle($(this));
            bundle.translation = $(this).val();
            helpers.update.bundle(bundle, $(this));
          }
        });

        $('.bundle-prize-select-item').on('change', function(e)
        {
          var bundle = helpers.selected.bundle($(this));
          var option = helpers.selected.option($(this));
          var item = helpers.item(option);
          
          bundle.prize.item = item;
          helpers.update.bundle(bundle, $(this));
        });

        $('.bundle-prize-input-quantity').on('propertychange change click keyup input paste blur', function(e)
        {
          var bundle = helpers.bundle($(this));
          bundle.prize.quantity = helpers.number($(this).val());
          helpers.update.bundle(bundle, $(this));
        });

        $('.bundle-requirement-select-item').on('change', function(e)
        {
          var bundle = helpers.selected.bundle($(this));
          var option = helpers.selected.option($(this));
          var item = helpers.item(option);
          
          var requirement = {};
          requirement.id = helpers.requirement.id(option);
          requirement.object = helpers.requirement.get(bundle, option);
          requirement.object.item = item;

          bundle.requirements[requirement.id] = requirement.object;
          helpers.update.bundle(bundle, $(this));
        });

        $('.bundle-requirement-input-quantity').on('propertychange change click keyup input paste blur', function(e)
        {

          var bundle = helpers.bundle($(this));
          var requirement = {};

          requirement.id = helpers.requirement.id($(this));
          requirement.object = helpers.requirement.get(bundle, $(this));
          requirement.object.quantity = helpers.number($(this).val());

          bundle.requirements[requirement.id] = requirement.object;
          helpers.update.bundle(bundle, $(this));
        });

        $('.bundle-requirement-select-quality').on('change', function(e)
        {
          var bundle = helpers.selected.bundle($(this));
          var option = helpers.selected.option($(this));
          
          var requirement = {};
          requirement.id = helpers.requirement.id(option);
          requirement.object = helpers.requirement.get(bundle, option);
          requirement.object.quality.name = helpers.quality.name(option);
          requirement.object.quality.value = helpers.quality.value(option);

          bundle.requirements[requirement.id] = requirement.object;
          helpers.update.bundle(bundle, $(this));
        });

        $('.bundle-money-input-quantity').on('propertychange change click keyup input paste blur', function(e)
        {
          var bundle = helpers.bundle($(this));
          bundle.money.quantity = helpers.number($(this).val());
          bundle.money.value = helpers.number($(this).val());
          helpers.update.bundle(bundle, $(this));
        });

        $('.submit').on('click', function(e)
        {
          var form = $('#form');
          $('#param-bundles').val(JSON.stringify(bundles));
          $('#param-lang').val('{{$lang}}');
          form.submit();
        });

        // only allow numbers
        $('.numeric').on('propertychange change click keyup input paste blur', function(e)
        {
          
          $(e.target).val($(e.target).val().replace(/[^\d]/g, ''));
          
          if ($(e.target).val().length == 0) 
          {
              $(e.target).val(0);
          }
          else 
          {
              $(e.target).val(parseInt($(e.target).val()));
          }
        });
    });
  </script>
@endsection
@section('content')

<div class="container" id="main">
  
  <div class="tile is-ancestor has-text-centered padding-top-20px">
    <div class="tile is-parent">
      <div class="tile is-child"></div>
      <div class="tile is-child is-8">
        <h2 class="title is-3">{{__('New Community Center')}}</h2>
      </div>
      <div class="tile is-child"></div>
    </div>
  </div> <!-- /title -->
  
  <div class="tile is-ancestor has-text-right">
    <div class="tile is-parent">
      <div class="tile is-child">
        <button class="submit button is-primary is-medium">{{__('Create Yaml')}}</button>
      </div>
    </div>
  </div>

  @foreach($bundles as $bundle)
  <span class="bundle" id="bundle-{{$bundle->id}}" data-bundle-id="{{$bundle->id}}"></span>
  <div class="tile is-ancestor">
    <div class="tile is-parent">
  
      <div class="tile is-child">
        <div class="bundle" id="bundle-{{$bundle->id}}">
          <h4 class="title is-4">{{$bundle->raw}} : {{$bundle->title}}</h4>
          <div class="tile is-ancestor">
            <div class="tile is-parent">
              <div class="tile is-child is-4">
                  <div class="field bundle-name" id="bundle-name-{{$bundle->id}}">
                        <label class="label">{{__('Bundle Name')}}</label>
                        <p class="control">
                          <input class="input bundle-input-name"
                                id="bundle-input-name-{{$bundle->id}}"
                                type="text" 
                                placeholder="{{__('Bundle Name')}}"
                                value="{{$bundle->translation}}"
                                data-bundle-id="{{$bundle->id}}"
                                data-index="{{$loop->index}}"
                                data-bundle-index="{{$loop->index}}"
                                required>
                        </p>
                  </div> <!-- /bundle-name -->
              </div> <!-- /is-child -->
              <div class="tile is-child is-1"></div>

              <div class="tile is-child">
                <label class="label">{{__('Prize')}}</label>
                <div class="field bundle-prize" id="bundle-prize-{{$bundle->id}}">
                        <p class="control">
                          <span>
                            <select class="chosen-select bundle-select bundle-prize-select-item bundle-prize-select-item-{{$bundle->id}}">
                              @foreach($items as $item)
                                <option class="bundle-prize-select-item-option bundle-prize-select-item-option-{{$bundle->id}} {{$item->uid}}" 
                                      id="bundle-prize-select-item-option-{{$bundle->id}}-{{$loop->parent->index}}-{{$item->uid}}"
                                      data-item-id="{{$item->id}}"
                                      data-item-category="{{$item->category}}"
                                      data-item-type="{{$item->type}}"
                                      data-item-name="{{$item->name}}"
                                      data-item-uid="{{$item->uid}}"
                                      data-bundle-id="{{$bundle->id}}"
                                      data-index="{{$loop->parent->index}}"
                                      data-index-loop="{{$loop->index}}"
                                      data-bundle-index="{{$loop->parent->index}}"

                                      @if($bundle->prize->item->uid === $item->uid)
                                        selected
                                      @endif
                                      >
                                      {{$item->name}} / {{$item->id}}
                                </option>
                              @endforeach
                            </select>
                          </span>
                        </p>
                </div>
              </div><!-- /is-child -->
              <div class="tile is-child is-1"></div>
              <div class="tile is-child">
                <div class="field">
                          <label class="label">{{__('Quantity')}}</label>
                          <p class="control">
                            <input class="input numeric bundle-prize-input-quantity bundle-prize-input-quantity-{{$bundle->id}}"
                                  id="bundle-prize-input-quantity-{{$bundle->id}}-{{$loop->index}}"
                                  type="text"
                                  placeholder="{{__('Quantity')}}"
                                  data-bundle-id="{{$bundle->id}}"
                                  data-bundle-index="{{$loop->index}}"
                                  data-index="{{$loop->index}}"
                                  value="{{$bundle->prize->quantity}}"
                                  required>
                          </p>
                </div>
              </div><!--- /is-child -->
            </div> <!-- /is-parent -->
          </div> <!-- /is-ancestor -->
          @if(!$bundle->money->active)
          <table class="table is-striped">
            <thead>
              <tr>
                <th>
                  {{__('Item')}}
                </th>
                <th>
                  {{__('Quantity')}}
                </th>
                <th>
                  {{__('Quality')}}
                </th>
              </tr>
            </thead>
            <tbody>
                @foreach($bundle->requirements as $requirement)
                  <tr class="bundle-requirement">
                    <td class="bundle-requirement-select">
                      <div class="field bundle-requirement" id="bundle-requirement-{{$bundle->id}}-{{$requirement->sort}}">
                        <p class="control">
                          <span>
                            <select class="chosen-select bundle-select bundle-requirement-select-item bundle-requirement-select-item-{{$bundle->id}}"
                                    id="bundle-requirement-select-item-{{$bundle->id}}-{{$loop->index}}">
                              @foreach($items as $item)
                                <option class="bundle-requirement-select-item-option bundle-requirement-select-item-option-{{$bundle->id}} {{$item->uid}}" 
                                      id="bundle-requirement-select-item-option-{{$bundle->id}}-{{$loop->parent->index}}-{{$loop->index}}-{{$item->uid}}"
                                      data-item-id="{{$item->id}}" 
                                      data-item-category="{{$item->category}}" 
                                      data-item-type="{{$item->type}}"
                                      data-item-uid ="{{$item->uid}}"
                                      data-bundle-id ="{{$bundle->id}}"
                                      data-index="{{$loop->parent->index}}"
                                      data-bundle-index="{{$loop->parent->index}}"
                                      data-index-loop="{{$loop->index}}"

                                      @if($requirement->item->uid === $item->uid)
                                        selected
                                      @endif
                                      >
                                      {{$item->name}} / {{$item->id}}
                                </option>
                              @endforeach
                            </select>
                          </span>
                        </p>
                      </div>
                    </td>
                    <td class="bundle-requirement-quantity">
                      <div class="tile is-3">
                        <div class="field">
                          <p class="control">
                            <input class="input numeric bundle-requirement-input-quantity bundle-requirement-input-quantity-{{$bundle->id}}"
                                  id="bundle-requirement-input-quantity-{{$bundle->id}}-{{$loop->index}}"
                                  type="text"
                                  placeholder="{{__('Quantity')}}"
                                  value="{{$requirement->quantity}}"
                                  data-bundle-id="{{$bundle->id}}"
                                  data-bundle-index="{{$loop->parent->index}}"
                                  data-index="{{$loop->index}}"
                                  required>
                          </p>
                        </div>
                      </div>
                    </td>
                    <td class="bundle-requirement-quality">
                      <div class="field">
                        <p class="control">
                          <span class="select">
                            <select class="bundle-select bundle-requirement-select-quality bundle-requirement-select-quality-{{$bundle->id}}"
                                    id="bundle-requirement-select-quality-{{$bundle->id}}-{{$loop->index}}">
                              @foreach($qualities as $quality)
                                <option class="bundle-requirement-select-quality-option bundle-requirement-select-quality-option-{{$bundle->id}}"
                                      id="bundle-requirement-select-quality-{{$bundle->id}}-{{$loop->parent->index}}-{{$loop->index}}"
                                      data-quality-name="{{$quality->name}}"
                                      data-quality-value="{{$quality->value}}"
                                      data-bundle-id="{{$bundle->id}}"
                                      data-bundle-index="{{$loop->parent->index}}"
                                      data-index="{{$loop->parent->index}}"
                                      data-index-loop="{{$loop->index}}"
                                      value="{{$quality->value}}"

                                @if($requirement->quality->value === $quality->value)
                                  selected
                                @endif
                                >
                                  {{$quality->name}}
                                </option>
                              @endforeach
                            </select>
                          </span>
                        </p>
                      </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          @else
            <div class="tile is-ancestor">
              <div class="tile is-parent">
                <div class="tile is-child is-2">
                  <div class="field">
                    <label class="label">{{__('Money')}}</label>
                    <p class="control">
                      <input class="input numeric bundle-money-input-quantity bundle-money-input-quantity-{{$bundle->id}}"
                            id="bundle-money-input-quantity-{{$bundle->id}}-{{$loop->index}}"
                            type="text"
                            placeholder="{{__('Money')}}"
                            value="{{$bundle->money->quantity}}"
                            data-bundle-id="{{$bundle->id}}"
                            data-bundle-index="{{$loop->index}}"
                            data-index="{{$loop->index}}"
                            required>
                    </p>
                  </div><!-- /field -->
              </div><!--- /is-child -->
              </div><!-- /is-parent -->
            </div> <!-- /is-ancestor -->
          @endif
        </div> <!-- /bundle -->
      </div> <!-- /is-child -->
    </div> <!-- /is-parent -->
  </div> <!-- /is-ancestor -->
  @endforeach 
  <div class="tile is-ancestor has-text-right">
    <div class="tile is-parent">
      <div class="tile is-child">
        <button class="submit button is-primary is-medium">{{__('Create Yaml')}}</button>
      </div>
    </div>
  </div>
  <form id="form" action="{{URL::to('/bundle/create')}}" method="post">
    {{ csrf_field() }}
    <input id="param-bundles" type="hidden" value="" name="bundles">
    <input id="param-lang" type="hidden" value="" name="lang">
  </form>
</div> <!-- /container -->
@endsection