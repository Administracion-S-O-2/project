@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Unidad habitacional</h1>
        <div class="row d.flex flex-column justify-content-center align-items-center">
            <form class="col-4 card p-3 m-3" action="{{ route('unidad.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form mb-3">
                    <label for="floatingInput">Id</label>
                    <input type="text" class="form-control" name="id" value="{{ $unidad->id }}" readonly>
                </div>
                <div class="form mb-3">
                    <label for="floatingInput">Calle</label>
                    <input type="text" class="form-control" name="street" value="{{ $unidad->street }}" readonly>
                </div>
                <div class="form mb-3">
                    <label for="">Num. de puerta</label>
                    <input class="form-control" type="text" name="door" value="{{ $unidad->door }}" readonly> 
                </div>
                <div class="form mb-3">
                    <label for="floatingInput">Etapa actual</label>
                    <input type="text" class="form-control" name="etapaName" value="{{ $unidad->etapa->name }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="etapa">Etapas disponibles para asignacion</label>
                    <select class="form-select" name="etapa_id" id="floatingSelect" aria-label="Floating label select example">
                        @foreach($etapas as $etapa){
                             <option name="etapa_id" value="{{ $etapa->id}}">{{ $etapa->name }}</option>
                        }
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Actualizar</button>
            </form>
            <div class="col-4 mt-3">
                <h3>Datos de socios asignados</h2>
                <table class=" table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->lastname }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

@include('componentes.footer')