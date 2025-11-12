@include('componentes.header')

    <section class="container-fluid mt-3">
        <h2 class="text-center">Socios</h2>
        <div class="row justify-content-center align-content-center">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha ingreso</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Email</th>
                            <th scope="col">Estado de pago mensual</th>
                            <th scope="col">Horas trabajadas este mes</th>
                            <th scope="col">Dir. unidad asignada</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($users) && $users->count() > 0)
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    @if($user->monthlyPaymentState())
                                        <td class="text-success">
                                            Al dia
                                        </td>
                                    @else
                                        <td class="text-warning">
                                            Atrasado
                                        </td>
                                    @endif
                                    <td>{{ $user->workedHoursThisMonth() }}</td>
                                    @if($user->UnidadHabitacional === null)
                                        <td>Sin unidad</td>
                                    @else 
                                        <td>
                                            {{ $user->UnidadHabitacional->street }} 
                                            {{ $user->UnidadHabitacional->door }}  
                                        </td>
                                    @endif
                                    <td>
                                        
                                    <a href="/user/{{ $user->id }}/workHours"><i class="bi bi-clock-fill"></i></a>
                                        <a href="/user/{{ $user->id }}/comprobantes"><i class="bi bi-files"></i></a>
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