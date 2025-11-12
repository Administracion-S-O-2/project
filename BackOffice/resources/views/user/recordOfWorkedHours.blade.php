@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Historial de horas de trabajo</h1>
        <div class="row justify-content-center align-content-center">
            <div class="col-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col">Fecha registrado</th>
                            <th class="col">Horas</th>
                        </tr>
                    </thead>
                    </tbody>
                        @foreach($hours as $hour)
                            <tr>
                                <td>{{ $hour->created_at }}</td>
                                <td>{{ $hour->hours }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
@include('componentes.footer')