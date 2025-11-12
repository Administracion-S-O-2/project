@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Asignar unidad a socio</h1>
        <div class="row justify-content-center align-items-center">
            <form class="col-3 card p-2" action="/user/assigne" method="POST">
                @csrf
                @method('PUT')
                <div class="">       
                    <label for="unidad_id">Id unidad habitacional</label>           
                    <input 
                        type="text"
                        class="form-control" 
                        name="unidad_id" 
                        id="floatingInputValue" 
                        placeholder="{{ $unidad->id }}" 
                        value="{{ $unidad->id }}"
                        required readonly
                    >
                </div>
                <div class="mb-2">
                    <label for="street">Calle</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="street" 
                        id="floatingInputStreet" 
                        placeholder="{{ $unidad->street }}" 
                        required readonly
                    >
                </div>
                <div class="mb-2">
                    <label for="door">Num. de puerta</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="door" 
                        id="floatingInputDoor" 
                        placeholder="{{ $unidad->door }}" 
                        required readonly
                    >
                </div>
                <div class="mb-2">
                    <label for="etapa">Etapa</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="etapa" 
                        id="floatingInputEtapa" 
                        placeholder="{{ $unidad->etapa->name }}" 
                        required readonly
                    >
                </div>
                <label for="socios">Socios</label>
                <select class="form-select" name="user_id" id="floatingSelect" aria-label="Floating label select example">
                    @foreach($users as $user){
                        <option name="user_id" value="{{ $user->id}}">{{ $user->name }} {{ $user->lastname }}</option>
                    }
                    @endforeach
                </select>
                <button class="mt-2 btn btn-primary" type="submit">Asignar</button>
            </form>
        </div>
    </section>

@include('componentes.footer')