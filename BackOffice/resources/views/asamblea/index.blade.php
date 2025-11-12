@include('componentes.header')

    <section class="container-fluid mt-3">
        <h2 class="text-center">Asambleas</h2>
        <div class="row justify-content-center align-content-center">
            <div class="col-10">
                <a class="m-1" href="{{ route('asamblea.create.view') }}"><i class="bi bi-plus-square"></i>Convocar asamblea</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha de reunion</th>
                            <th scope="col">Proposito</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Cant. de socios a asistir</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($asambleas) && $asambleas->count() > 0)
                            @foreach ($asambleas as $asamblea)
                                <tr>
                                    <td>{{ $asamblea->assembly_date }}</td>
                                    <td>{{ $asamblea->purpose }}</td>
                                    <td>{{ $asamblea->type }}</td>
                                    <td>{{ $asamblea->usersToAssist() }}</td>
                                    <td>
                                        <a href="/asamblea/{{ $asamblea->id }}" class="fs-5 mx-2">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
        </div>
        <a href="{{ route('asamblea.create.view') }}" class="rounded-circle position-absolute bottom-0 end-0 text-light fs-2">
            <i class="bi bi-plus-circle p-1 bg-primary"></i>
        </a>
    </section>
    
@include('componentes.footer')