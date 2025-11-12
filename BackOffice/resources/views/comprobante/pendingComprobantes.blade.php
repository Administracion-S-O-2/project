@include('componentes.header')

    <section class="container-fluid mt-3 ">
        <h2 class="text-center">Comprobantes pendientes</h2>
        <div class="row justify-content-center">
            <div class="col-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha registrado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">cantidad horas</th>
                            <th scope="col">Socio</th>
                            <th scope="col">Gmail socio</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comprobantes as $c)
                            <tr>
                                <td>{{ $c->created_at }}</td>
                                <td>{{ $c->type }}</td>
                                <td>{{ $c->totalHours }}</td>
                                <td>{{ $c->user->name }}</td>
                                <td>{{ $c->user->email }}</td>
                                <td>
                                    <a href="/comprobante/approve/{{ $c->id }}"><i class="mx-1 fs-5 bi bi-check2-square text-success"></i></a>
                                    <a href="/comprobante/refuse/{{ $c->id }}"><i class="mx-1 fs-6 bi bi-x-square text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           
    </section>
    
@include('componentes.footer')