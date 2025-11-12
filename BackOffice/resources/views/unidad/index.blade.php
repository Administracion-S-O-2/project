@include('componentes.header')

    <section class="container-fluid mt-3">
        <h2 class="text-center">Unidades habitacionales</h2>
        <div class="row justify-content-center">
            <div class="col-10">
                <a href="http://localhost:8000/unidad/create"><i class="bi bi-house-add fs-1"></i></a>
                <a href="http://localhost:8000/etapa/create"><input type="button" value="Agregar etapa"></a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Calle</th>
                            <th scope="col">Num. puerta</th>
                            <th scope="col">Cant. socios asignados</th>
                            <th scope="col">Etapa</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($unidades) && $unidades->count() > 0)
                            @foreach ($unidades as $unidad)
                                <tr>
                                    <td>{{ $unidad->id }}</td>
                                    <td>{{ $unidad->street }}</td>
                                    <td>{{ $unidad->door }}</td>
                                    <td>{{ $unidad->users->count()}}</td>
                                    <td>{{ $unidad->etapa->name }}</td>
                                    <td>
                                        <a href="http://localhost:8000/unidad/detail/{{ $unidad->id }}" class="mx-2 fs-5">
                                            <i class="bi bi-house-gear"></i>
                                        </a>
                                        <a href="http://localhost:8000/unidad/assigne/{{ $unidad->id }}" class="mx-2 fs-5">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
@include('componentes.footer')