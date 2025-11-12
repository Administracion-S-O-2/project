@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Alta unidad habitacional</h1>
        <div class="row justify-content-center align-items-center">
            <form class="col-4 card p-3 m-3" action="/unidad" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="street" id="floatingInputStreet" placeholder="rivera" required>
                    <label for="floatingInput">Calle</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="door" id="floatingInputDoor" placeholder="121" required>
                    <label for="floatingInput">Num. de puerta</label>
                </div>
                <div class="mb-3">
                    <label for="etapa">Etapa</label>
                    <select class="form-select" name="etapa_id" id="floatingSelect" aria-label="Floating label select example">
                        @foreach($etapas as $etapa){
                             <option name="etapa_id" value="{{ $etapa->id}}">{{ $etapa->name }}</option>
                        }
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Crear</button>
            </form>
        </div>
    </section>
    
@include('componentes.footer')