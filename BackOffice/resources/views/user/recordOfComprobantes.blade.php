@include('componentes.header')

    <section class="container-fluid mt-3">
        <h2 class="text-center">Historial de comprobantes de socio</h2>
        <div class="row justify-content-center align-content-center">
            <div class="col-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha registrado</th>
                            <th scope="col">Fecha evaluado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Cantidad horas</th>
                            <th scope="col">Socio</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comprobantes as $c)
                            <tr>
                                <td>{{ $c->created_at }}</td>
                                <td>{{ $c->dateManaged }}</td>
                                <td>{{ $c->type }}</td>
                                <td>{{ $c->totalHours }}</td>
                                <td>{{ $c->user->name }}</td>
                                @if($c->state == 'Refused')
                                    <td class="text-danger">{{ $c->state }}</td>
                                @elseif($c->state == 'Approved')
                                    <td class="text-success">{{ $c->state }}</td>
                                @else
                                    <td class="text-warning">{{ $c->state }}</td>
                                @endif
                                <td>
                                    @if($c->state == 'Pending')
                                        <a href="/comprobante/approve/{{ $c->id }}"><i class="mx-1 fs-5 bi bi-check2-square text-success"></i></a>
                                        <a href="/comprobante/refuse/{{ $c->id }}"><i class="mx-1 fs-6 bi bi-x-square text-danger"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
@include('componentes.footer')