<form action="{{route('visualizza_chilometri_ragazzi')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col form-group">
            <label for="ragazzo" class="text-white">Ragazzo</label>
            <select required class="custom-select" name="ragazzo" id="ragazzo">
                <option value=""></option>
                @foreach($ragazzi as $ragazzo)
                    <option value={{$ragazzo->id}}>{{$ragazzo->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col form-group">
            <div class="container pl-1">
                <div class="row row-cols-6" style="margin-left: -8px">
                    @for($i = 1; $i <= 12; $i++)
                        <div class="col">
                            <div class="custom-control custom-checkbox checkbox-xl">
                                <input type="checkbox" class="custom-control-input" name="mesi[]" value="{{$i}}"
                                       id="defaultCheck1.{{$i}}">
                                <label class="custom-control-label text-white" for="defaultCheck1.{{$i}}">{{$i}}</label>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col form-group">
            <label for="anno" class="text-white">Anno</label>
            <select class="custom-select" name="anno" id="anno">
                @for($i = 2020; $i <= $annooggi; $i++)
                    <option value={{$i}}>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block">Cerca</button>
</form>
