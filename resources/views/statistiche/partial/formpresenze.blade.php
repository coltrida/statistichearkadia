<form action="{{route('visualizza_statistiche')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-6 form-group">
            <label for="ragazzo" class="text-white">Nome</label>
            <select required class="custom-select" name="ragazzo" id="ragazzo">
                <option value=""></option>
                @foreach($ragazzi as $raga)
                    <option value={{$raga->id}}>{{$raga->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3 form-group">
            <label for="mese" class="text-white">Mese</label>
            <select required class="custom-select" name="mese" id="mese">
                <option value=""></option>
                @for($i = 1; $i <= 12; $i++)
                    <option value={{$i}}>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-3 form-group">
            <label for="anno" class="text-white">Anno</label>
            <select required class="custom-select" name="anno" id="anno">
                @for($i = 2020; $i <= $annooggi; $i++)
                    <option selected="{{ $i == $annooggi }}" value={{$i}}>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-lg btn-block">Cerca</button>
</form>
